<?php

namespace WebApp\DataModel;

class User implements \WebApp\Auth\Principal {

	public const STATUS_REGISTERED = 'registered';
	public const STATUS_CONFIRMED  = 'confirmed';
	public const STATUS_ACTIVE     = 'active';
	public const STATUS_DISABLED   = 'disabled';
	public const STATUS_DELETED    = 'deleted';

	public function __construct() {
	}

	/**
	 * Principal method.
	 */
	public function getId() {
		return $this->uid;
	}

	public function verifyPassword($password) {
		if (substr($this->password, 0, 1) != '$') {
			$this->setPassword($this->password);
		}
		return password_verify($password, $this->password);
	}

	public function setPassword($password) {
		$this->password = password_hash($password, PASSWORD_DEFAULT);
	}

	/** Checks password criteria */
	public function passwordCriteriaMatched($password) {
		return strlen($password) >= 8;
	}

	public function getRoles() {
		$rc = array();
		if (is_string($this->roles)) {
			$rc = explode(',', $this->roles);
		}
		return $rc;
	}

	public function hasRole($s) {
		return in_array($s, $this->getRoles());
	}

	public function addRole($s) {
		if (!$this->hasRole($s)) {
			$arr   = $this->getRoles();
			$arr[] = $s;
			$this->setRoles($arr);
		}
	}

	public function setRoles($arr) {
		if (is_string($arr)) $this->roles = $arr;
		else if (is_array($arr)) $this->roles = implode(',', $arr);
	}

	public function isActive() {
		return $this->status == User::STATUS_ACTIVE;
	}

	public function getData() {
		if ($this->data == NULL) {
			$this->data = new \stdClass;
		} else if (is_string($this->data) && (substr($this->data, 0, 1) == '{')) {
			$this->data = json_decode($this->data);
		}
		return $this->data;
	}

	public function setData($obj) {
		if (is_object($obj)) $this->data = json_encode($obj);
		else throw new \WebApp\WebAppException('Data must be an object');
	}

	public function getSecurityData() {
		$data = $this->getData();
		if (!isset($data->security)) {
			$data->security = new \stdClass;
			$data->security->failedAttempts    = 0;
			$data->security->lastFailedAttempt = 0;
			$data->security->blocked           = FALSE;
			$data->security->blockedExpiryTime = 0;
		}
		return $data->security;
	}

	/**
	 * Checks whether user is allowed to login.
	 * A user can be temporarily blocked or not in status active.
	 */
	public function isBlocked() {
		return $this->isPermanentlyBlocked() || $this->isTemporarilyBlocked();
	}

	/**
	 * Returns whether the user is permanently blocked from login
	 */
	public function isPermanentlyBlocked() {
		return $this->status != User::STATUS_ACTIVE;
	}

	/**
	 * Returns whether the user is temporarily blocked from login
	 */
	public function isTemporarilyBlocked() {
		$rc = FALSE;
		$data = $this->getSecurityData();
		if ($data->blocked && (time() < $data->blockedExpiryTime)) {
			$rc = TRUE;
		}
		return $rc;
	}

	/**
	 * Registers a failed attempt to login and blocks the user for 10 minutes when more than 3 attempts were registered.
	 * @return bool TRUE when the user is now blocked temporarily.
	 */
	public function registerFailedLoginAttempt() {
		$data = $this->getSecurityData();
		$data->failedAttempts++;
		$data->lastFailedAttempt = time();
		if ($data->failedAttempts > 3) {
			$data->blocked           = TRUE;
			$data->blockedExpiryTime = time()+10*\TgUtils\Date::SECONDS_PER_MINUTE;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Registers a successful login and resets the blocking values.
	 */
	public function registerSuccessfulLogin() {
		$data = $this->getSecurityData();
		$data->failedAttempts    = 0;
		$data->blocked           = FALSE;
		$data->blockedExpiryTime = 0;
	}

	public function __toString() {
		return $this->name;
	}
}
