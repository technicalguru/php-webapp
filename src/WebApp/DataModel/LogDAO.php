<?php

namespace WebApp\DataModel;

use TgUtils\Date;
use TgDatabase\Restrictions;
use WebApp\WebAppException;

class LogDAO extends \TgDatabase\DAO {

	public function __construct($database, $checkTable = FALSE) {
		parent::__construct($database, '#__error_log', 'WebApp\\DataModel\\Log', 'uid', $checkTable);
	}

	public function createTable() {
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
		return TRUE;
	}

	public function deleteAll() {
		return $this->createQuery()->delete();
	}

	public function housekeeping($days = 30) {
		$threshold = new Date(time()-$days*Date::SECONDS_PER_DAY, WFW_TIMEZONE);
		$this->createQuery(NULL, Restrictions::lt('log_date', $threshold))->delete();
	}
}

