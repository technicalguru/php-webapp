<?php

namespace WebApp\Component;

class Checkbox extends Input {

	public function __construct($parent, $id, $value) {
		parent::__construct($parent, $id, 'checkbox', $value);
	}

	public function setChecked($value) {
		$this->setAttribute('checked', $value ? 'checked' : NULL);
	}

	public function isChecked() {
		return $this->getAttribute('checked', TRUE) == 'checked';
	}
}

