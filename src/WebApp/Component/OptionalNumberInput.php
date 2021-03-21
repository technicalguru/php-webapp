<?php

namespace WebApp\Component;

class OptionalNumberInput extends EnableByCheckGroup {

	public function __construct($parent, $id, $label, $checkText, $value) {
		parent::__construct($parent, $id, $label, $checkText, $value);
	}

	protected function createInput($parent, $id, $value) {
		$rc = new NumberInput($parent, $id, $value);
		return $rc;
	}

	public function setPlaceholder($value) {
		$this->input->setPlaceholder($value);
	}

	public function setMin($value) {
		$this->input->setMin($value);
	}

	public function setMax($value) {
		$this->input->setMax($value);
	}

	public function setStep($value) {
		$this->input->setStep($value);
	}
}

