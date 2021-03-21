<?php

namespace WebApp\Component;

class FlexBox extends Div {

	public function __construct($parent) {
		parent::__construct($parent);
		$this->addClass('flex-box');
	}

	public function createFixedItem($content = NULL) {
		return new FlexItem($this, $content);
	}

	public function createItem($content = NULL) {
		$rc = new FlexItem($this, $content);
		$rc->addClass('flex-item-grow');
		return $rc;
	}
}

