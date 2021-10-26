<?php

namespace WebApp\DataModel;

use TgUtils\Date;
use TgDatabase\Restrictions;
use WebApp\WebAppException;

/** DataModel class for sessions */
class SessionDAO extends \TgDatabase\DAO {

	public function __construct($database, $checkTable = FALSE) {
		parent::__construct($database, '#__sessions', 'WebApp\\DataModel\\Session', 'uid', $checkTable);
	}

	public function createTable() {
		// Create it (try)
		$sql =
			'CREATE TABLE '.$this->database->quoteName($this->tableName).' ( '.
				'`uid` VARCHAR(50) NOT NULL COMMENT \'ID of session\', '.
				'`creation_time` DATETIME NOT NULL COMMENT \'When was session created\', '.
				'`update_time` DATETIME NOT NULL COMMENT \'When was session last updated\', '.
				'`expiry_time` DATETIME NOT NULL COMMENT \'When will session expire\', '.
				'`data` TEXT COLLATE utf8mb4_bin NOT NULL COMMENT \'session data\', '.
				'`persistent` INT(1) UNSIGNED NOT NULL DEFAULT \'0\' COMMENT \'Is session persistent?\', '.
				'PRIMARY KEY (`uid`) '.
			') ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT = \'Sessions\'';
		$res = $this->database->query($sql);
		if ($res === FALSE) {
			throw new WebAppException('Cannot create session table: '.$this->database->error());
		}
		return TRUE;
	}

	/** Create the given sessions */
	public function create($object) {
		$k   = $this->idColumn;
		$rc  = $this->database->insert($this->database->quoteName($this->tableName), $object);
		if ($rc === FALSE) return NULL;
		return $object->$k;
	}

	public function expire($maxlifetime) {
		$now    = new Date(time(), WFW_TIMEZONE);
		$this->createQuery(NULL, array(
			Restrictions::lt('expiry_time', $now),
			Restrictions::eq('persistent', 0),
		))->delete();
	}
}
