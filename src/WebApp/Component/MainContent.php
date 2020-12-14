<?php

namespace WebApp\Component;

class MainContent extends Div {

	public function __construct($parent, $child = NULL) {
		parent::__construct($parent, $child);
		$this->addClass('content-main');
	}

}

