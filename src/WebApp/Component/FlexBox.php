<?php

namespace WebApp\Component;

class FlexBox extends Div {

	public function __construct($parent) {
		parent::__construct($parent);
		$this->addClass('flex-box');
	}

	public function createItem($content = NULL) {
		return new FlexItem($this, $content);
	}
}

