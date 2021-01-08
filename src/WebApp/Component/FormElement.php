<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class FormElement extends BasicFormElement {

	protected $error;

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id);
		$this->setValue($value);
	}

	public function getError() {
		return I18N::_($this->error);
	}

	public function setError($value) {
		$this->error = $value;
	}

	public function getValue() {
		return $this->getAttribute('value', TRUE);
	}

	public function setValue($value) {
		if (is_int($value)) $value = ''.$value;
		$this->setAttribute('value', $value);
	}

}
