<?php

namespace WebApp\Component;

use TgI18n\I18N;

/** A single tab in a TabSet */ 
class Tab extends Container {

	public $label;
	public $active;

	public function __construct($parent, $id, $label, $content = NULL) {
		parent::__construct($parent, $content);
		$this->setId($id);
		$this->setLabel($label);
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function setActive($value) {
		$this->active = $value;
	}

	public function isActive() {
		return $this->active;
	}
}
