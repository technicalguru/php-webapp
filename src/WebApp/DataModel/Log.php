<?php

namespace WebApp\DataModel;

class Log {

	public function __construct() {
		if (is_string($this->log_text)) $this->log_text = json_decode($this->log_text);
	}

}
