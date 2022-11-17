<?php

namespace WebApp\DataModel;

class AccessLog {

	public $uid;
	public $session_id;
	public $log_time;
	public $response_code;
	public $method;
	public $path;
	public $referer;
	public $ua;
	public $user_id;

	public function __construct() {
		if (is_string($this->log_time)) $this->log_time = new \TgUtils\Date($this->log_time, WFW_TIMEZONE);
	}
}
