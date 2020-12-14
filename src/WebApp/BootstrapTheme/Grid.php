<?php

namespace WebApp\BootstrapTheme;

class Grid extends \WebApp\Component\Div {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function createRow() {
		return new GridRow($this);
	}
}

