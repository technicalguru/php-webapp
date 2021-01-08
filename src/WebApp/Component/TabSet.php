<?php

namespace WebApp\Component;

/** A single tab in a TabSet */ 
class TabSet extends Container {

	public function __construct($parent, $id = NULL) {
		parent::__construct($parent);
		if ($id != NULL) $this->setId($id);
	}

	public function createTab($id, $label, $content = NULL) {
		return new Tab($this, $id, $label, $content);
	}
}
