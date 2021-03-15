<?php

namespace WebApp\Component;

class MainContent extends Div {

	public function __construct($parent, $child = NULL, $renderMessages = TRUE) {
		parent::__construct($parent, $child);
		$this->addClass('content-main');
		if ($renderMessages) {
			$msg = new SystemMessages($this);
			$msg->addClass('mb-4');
		}
	}

}

