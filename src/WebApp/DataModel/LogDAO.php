<?php

namespace WebApp\DataModel;

use WebApp\WebAppException;

class LogDAO extends \TgDatabase\DAO {

	public function __construct($database) {
		parent::__construct($database, '#__error_log', 'WebApp\\DataModel\\Log');
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
					'`log_date` datetime NOT NULL,'.
					'`log_text` text COLLATE utf8mb4_bin NOT NULL,'.
					'`log_sent` datetime DEFAULT NULL,'.
					'PRIMARY KEY (`uid`)'.
				') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin';
			$res = $this->database->query($sql);
			if ($res === FALSE) {
				throw new WebAppException('Cannot create log table: '.$this->database->error());
			}
		}
	}

}

