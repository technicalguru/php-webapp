<?php

namespace WebApp\Component;

use TgI18n\I18N;

class FieldSet extends Container {

	protected $name;
	protected $label;
	protected $visible;
	protected $enabled;

	public function __construct($parent, $id, $name, $label) {
		parent::__construct($parent);
		$this->setId($id);
		$this->name    = $name;
		$this->label   = $label;
		$this->visible = TRUE;
		$this->enabled = TRUE;
		$this->active  = FALSE;
	}

	public function getName() {
		return I18N::_($this->name);
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function isVisible() {
		return $this->visible;
	}

	public function setVisible($value) {
		$this->visible = $value;
	}

	public function isEnabled() {
		return $this->enabled;
	}

	public function setEnabled($value) {
		$this->enabled = $value;
	}

	public function isActive() {
		return $this->active;
	}

	public function setActive($value) {
		$this->active = $value;
	}

}
