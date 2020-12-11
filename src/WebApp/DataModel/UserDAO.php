<?php

namespace WebApp\DataModel;

use WebApp\WebAppException;

class UserDAO extends \TgDatabase\DAO {

	public function __construct($database) {
		parent::__construct($database, '#__users', 'WebApp\\DataModel\\User');
		$this->initialize();
	}

	protected function initialize() {
		// Check the table existence
		$res = $this->database->query('SELECT * FROM '.$this->tableName);
		if ($res === FALSE) {
			// Try to create
			$sql =
				'CREATE TABLE '.$this->database->quoteName($this->tableName).' ('.
					'`uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,'.
					'`email` varchar(250) COLLATE utf8mb4_bin NOT NULL,'.
					'`password` varchar(150) COLLATE utf8mb4_bin NOT NULL,'.
					'`name` varchar(50) COLLATE utf8mb4_bin NOT NULL,'.
					'`roles` varchar(250) COLLATE utf8mb4_bin NOT NULL,'.
					'`status` varchar(20) DEFAULT \'active\' NOT NULL,'.
					'`data` text COLLATE utf8mb4_bin NOT NULL,'.
					'PRIMARY KEY (`uid`) '.
				') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin';
			$res = $this->database->query($sql);
			if ($res === FALSE) {
				throw new WebAppException('Cannot create user table: '.$this->database->error());
			}
		}
	}

	public function getByEmail($email) {
		return $this->findSingle(array('email' => strtolower($email), array('status', User::STATUS_DELETED, '!=')));
	}

	public function findByRole($role) {
		$rc = array();
		$users = $this->find(array('status' => 'active', array('roles', '%'.$role.'%', 'LIKE')));
		foreach ($users AS $user) {
			if ($user->hasRole($role)) {
				$rc[] = $user;
			}
		}
		return $rc;
	}
		
	public function search($s) {
		$s = $this->database->escape(strtolower($s));
		$where = '(LOWER(name) LIKE \'%'.$s.'%\') OR (LOWER(email) LIKE \'%'.$s.'%\')';
		return $this->find($where);
	}
}

