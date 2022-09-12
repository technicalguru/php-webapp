<?php

namespace WebApp\DataModel;

class AccessLog {

	public $log_time;

	public function __construct() {
		if (is_string($this->log_time)) $this->log_time = new \TgUtils\Date($this->log_time, WFW_TIMEZONE);
	}
}
