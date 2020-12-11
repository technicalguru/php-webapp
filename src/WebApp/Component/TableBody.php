<?php

namespace WebApp\Component;

class TableBody extends Container {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function createRow() {
		return new TableRow($this);
	}
}

