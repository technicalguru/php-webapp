<?php

namespace WebApp\DataModel;

class Log {

	public function __construct() {
		if (is_string($this->log_text)) {
			if (substr($this->log_text, 0, 1) == '{') $this->log_text = json_decode($this->log_text);
		}
	}

}
