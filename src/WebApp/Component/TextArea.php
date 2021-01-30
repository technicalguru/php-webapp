<?php

namespace WebApp\Component;

class TextArea extends FormElement implements SingleValueComponent {

	protected $value;

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id);
		$this->setValue($value);
	}

	public function getValue() {
		return $this->value;
	}

	public function setValue($value) {
		$this->value = $value;
	}
}

