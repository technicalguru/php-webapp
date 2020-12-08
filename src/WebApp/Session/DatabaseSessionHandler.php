<?php

namespace WebApp\Session;

use TgUtils\Date;
use WebApp\DataModel\Session;

class DatabaseSessionHandler implements \SessionHandlerInterface {

	public  $dao;
	private $session;

	public function __construct($dao) {
		$this->dao      = $dao;
		$this->session  = NULL;
	}

	/**
	 * Opens the session
	 *
	 * @param string $save_path
	 * @param string $name
	 * @return bool
	 */
	public function open($save_path, $name) {
		return TRUE;
	}

	/**
	 * Reads the session data
	 *
	 * @param string $session_id
	 * @return string
	 */
	public function read($session_id) {
		$this->session = $this->dao->get($session_id);
		if (!$this->session) $this->createFreshSession($session_id);
		return $this->session->data;
	}

	/**
	 * makes the session un/persistent.
	 */
	public function setPersistent($persistent = TRUE) {
		$_SESSION['persistent'] = $persistent ? 1 : 0;
		if ($this->session != NULL) $this->session->persistent = $_SESSION['persistent'];
	}

	/** Creates a fresh session object */
	protected function createFreshSession($session_id) {
		$now    = new Date(time(), WFW_TIMEZONE);
		$expiry = new Date(time()+ini_get('session.gc_maxlifetime'), WFW_TIMEZONE);
		$this->session = new Session();
		$this->session->uid           = $session_id;
		$this->session->creation_time = $now->toMysql(TRUE);
		$this->session->update_time   = $now->toMysql(TRUE);
		$this->session->expiry_time   = $expiry->toMysql(TRUE);
		$this->session->data          = '';
		$this->session->persistent    = 0;
	}

	/**
	 * Writes the session data to the database
	 *
	 * @param string $session_id
	 * @param string $data
	 * @return bool
	 */
	public function write($session_id, $data) {

		// In case there is no object yet
		if ($this->session == NULL) $this->createFreshSession($session_id);

		// Update fields
		$now        = new Date(time(), WFW_TIMEZONE);
		$expiryTime = $_SESSION['persistent'] ? 365*24*3600 : ini_get('session.gc_maxlifetime');
		$expiry     = new Date(time()+$expiryTime, WFW_TIMEZONE);
		$this->session->update_time   = $now->toMysql(TRUE);
		$this->session->expiry_time   = $expiry->toMysql(TRUE);
		$this->session->data          = $data;
		$this->session->persistent    = $_SESSION['persistent'] ? 1 : 0;

		// Persist
		$session = $this->dao->get($session_id);
		if ($session == NULL) {
			// Insert
			$this->dao->create($this->session);
		} else {
			// update
			$session->update_time = $this->session->update_time;
			$session->expiry_time = $this->session->expiry_time;
			$session->data        = $this->session->data;
			$session->persistent  = $this->session->persistent;
			$this->dao->save($session);
		}
		return TRUE;
	}

	/**
	 * Closes the session and writes the session data to the database
	 *
	 * @return bool
	 */
	public function close() {
		if ($this->session) {
			return $this->gc(ini_get('session.gc_maxlifetime'));
		}
		return FALSE;
	}

	/**
	 * Destroys the session
	 *
	 * @param int $session_id
	 * @return bool
	 */
	public function destroy($session_id) {
		$this->createFreshSession($session_id);
		$this->dao->delete($this->session);
		return TRUE;
	}

	/**
	 * Garbage collection
	 *
	 * @param int $maxlifetime
	 * @return bool
	 */
	public function gc($maxlifetime) {
		// As we had the expiry set explicitely, we dont need the max lifetime
		$expired = $this->dao->expire($maxlifetime);
		return TRUE;
	}
}


