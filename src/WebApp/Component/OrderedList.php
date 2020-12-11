<?php

namespace WebApp\Component;

class OrderedList extends Container {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function addItem($content = NULL) {
		return new ListItem($this, $content);
	}
}

