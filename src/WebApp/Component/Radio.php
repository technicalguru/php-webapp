<?php

namespace WebApp\Component;

class Radio extends Input {

	public function __construct($parent, $id, $value) {
		parent::__construct($parent, $id, 'radio', $value);
	}

	public function setChecked($value) {
		$this->setAttribute('checked', $value ? 'checked' : NULL);
	}

	public function isChecked() {
		return $this->getAttribute('checked', TRUE) == 'checked';
	}
}

