<?php

namespace WebApp\Component;

use TgI18n\I18N;

class Divider extends Div {

	protected $label = NULL;
	protected $icon  = NULL;

	public function __construct($parent, $child = NULL) {
		parent::__construct($parent, $child);
		$this->addClass('divider');
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
		return $this;
	}

	public function getIcon() {
		return $this->icon;
	}

	public function setIcon($value) {
		$this->icon = $value;
		return $this;
	}

}

