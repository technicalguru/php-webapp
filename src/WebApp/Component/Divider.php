<?php

namespace WebApp\Component;

class Divider extends Div {

	public function __construct($parent, $child = NULL) {
		parent::__construct($parent, $child);
		$this->addClass('divider');
	}
}

