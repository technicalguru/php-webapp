<?php

namespace WebApp\Component;

class GridRow extends Div {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function createCell($content = NULL) {
		return new GridCell($this, $content);
	}
}

