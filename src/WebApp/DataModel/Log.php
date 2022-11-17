<?php

namespace WebApp\DataModel;

class Log {

	public $log_text;
	public $log_date;

	public function __construct() {
		if (is_string($this->log_text)) $this->log_text = json_decode($this->log_text);
		if (is_string($this->log_date)) $this->log_date = new \TgUtils\Date($this->log_date, WFW_TIMEZONE);
	}

	public function asText() {
		$rc = '';
		foreach (array('error', 'warn', 'info', 'debug') AS $sev) {
			if (isset($this->log_text->$sev)) {
				foreach ($this->log_text->$sev AS $msg) {
					$rc .= '['.mb_strtoupper($sev).'] '.$msg."\n";
				}
			}
		}
		return $rc;
	}

	public function getPreview() {
		$rc = '';
		foreach (array('error', 'warn', 'info', 'debug') AS $sev) {
			if (isset($this->log_text->$sev)) {
				foreach ($this->log_text->$sev AS $msg) {
					$rc = '['.mb_strtoupper($sev).'] '.$msg;
					break 2;
				}
			}
		}
		if (mb_strlen($rc) > 100) $rc = mb_substr($rc, 0, 100);
		return $rc;
	}
		
}
