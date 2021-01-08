<?php

namespace WebApp\Component;

class Grid extends Div {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function createRow() {
		return new GridRow($this);
	}
}

