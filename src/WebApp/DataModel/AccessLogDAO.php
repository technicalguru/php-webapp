<?php

namespace WebApp\DataModel;

use TgUtils\Date;
use TgDatabase\Restrictions;
use WebApp\WebAppException;

/** DataModel class for access logs */
class AccessLogDAO extends \TgDatabase\DAO {

	public function __construct($database, $checkTable = FALSE) {
		parent::__construct($database, '#__access_log', 'WebApp\\DataModel\\AccessLog', 'uid', $checkTable);
	}

	public function createTable() {
		// Create it (try)
		$sql =
			'CREATE TABLE '.$this->database->quoteName($this->tableName).' ( '.
				'`uid` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, '.
				'`session_id` VARCHAR(50) NOT NULL COMMENT \'ID of session\', '.
				'`log_time` DATETIME NOT NULL COMMENT \'When was access logged\', '.
				'`response_code` INT(5) UNSIGNED NOT NULL COMMENT \'HTTP Response Code\', '.
				'`method` VARCHAR(10) NOT NULL COMMENT \'HTTP method\', '.
				'`path` VARCHAR(200) NOT NULL COMMENT \'Path and params\', '.
				'`referer` VARCHAR(200) COMMENT \'Referer if given\', '.
				'`ua` VARCHAR(200) COMMENT \'User Agent\', '.
				'`user_id` INT(10) UNSIGNED NOT NULL COMMENT \'User ID if known\', '.
				'PRIMARY KEY (`uid`) '.
			') ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT = \'Access Log\'';
		$res = $this->database->query($sql);
		if ($res === FALSE) {
			throw new WebAppException('Cannot create access log table: '.$this->database->error());
		}
		return TRUE;
	}

	public function log($userId = 0, $request = NULL) {
		if ($request == NULL) $request = \TgUtils\Request::getRequest();
		if ($request != NULL) {
			$obj = new AccessLog();
			$obj->session_id    = session_id();
			$obj->log_time      = new \TgUtils\Date(time(), WFW_TIMEZONE);
			$obj->response_code = http_response_code();
			$obj->method        = $request->method;
			$obj->path          = $request->originalUri;
			$obj->referer       = $request->getHeader('referer');
			$obj->ua            = $request->getHeader('user-agent');
			$obj->user_id       = $userId;
			$this->create($obj);
		}
	}

	public function housekeeping($expiration = NULL) {
		if (!is_int($expiration) && !is_object($expiration)) $expiration = time()-60*\TgUtils\Date::SECONDS_PER_DAY;
		if (!is_object($expiration)) $expiration = new \TgUtils\Date($expiration, WFW_TIMEZONE);
		return $this->deleteBy(Restrictions::lt('log_time', $expiration));
	}
}
