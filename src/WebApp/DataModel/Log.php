<?php

namespace WebApp\DataModel;

class Log {

	public function __construct() {
		if (is_string($this->log_text)) $this->log_text = json_decode($this->log_text);
	}

	public function asText() {
		$rc = '';
		foreach (array('error', 'warn', 'info', 'debug') AS $sev) {
			if (isset($this->log_text->$sev)) {
				foreach ($this->log_text->$sev AS $msg) {
					$rc .= '['.strtoupper($sev).'] '.$msg."\n";
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
					$rc = '['.strtoupper($sev).'] '.$msg;
					break 2;
				}
			}
		}
		if (strlen($rc) > 100) $rc = substr($rc, 0, 100);
		return $rc;
	}
		
}
