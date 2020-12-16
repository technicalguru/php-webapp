<?php

namespace WebApp\DataModel;

use WebApp\WebAppException;

class UserRoleDAO extends \TgDatabase\DAO {

	public function __construct($database, $modelClass = NULL) {
		parent::__construct($database, '#__user_roles', $modelClass != NULL ? $modelClass : 'WebApp\\DataModel\\UserRole');
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
					'`name` varchar(50) COLLATE utf8mb4_bin NOT NULL,'.
					'`privileges` text COLLATE utf8mb4_bin NOT NULL,'.
					'`is_active` int(1) DEFAULT 1 NOT NULL,'.
					'PRIMARY KEY (`uid`), '.
					'UNIQUE(`name`) '.
				') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin';
			$res = $this->database->query($sql);
			if ($res === FALSE) {
				throw new WebAppException('Cannot create user roles table: '.$this->database->error());
			}
		}
	}

}

