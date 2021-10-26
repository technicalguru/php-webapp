<?php

namespace WebApp\DataModel;

class AccessLog {

	public function __construct() {
		if (is_string($this->log_date)) $this->log_date = new \TgUtils\Date($this->log_date, WFW_TIMEZONE);
	}

}
