<?php

namespace WebApp\BootstrapTheme;

class GridRow extends \WebApp\Component\Div {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function createCell($content = NULL) {
		return new GridCell($this, $content);
	}
}

