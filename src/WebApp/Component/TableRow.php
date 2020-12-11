<?php

namespace WebApp\Component;

class TableRow extends Container {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function createCell($text = NULL, $isHeading = FALSE) {
		return new TableCell($this, $text, $isHeading);
	}
}

