<?php

namespace WebApp\Component;

class NumberInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'number', $value);
	}

	public function getMin() {
		return $this->getAttribute('min', TRUE);
	}

	public function setMin($value) {
		$this->setAttribute('min', $value);
	}

	public function getMax() {
		return $this->getAttribute('max', TRUE);
	}

	public function setMax($value) {
		$this->setAttribute('max', $value);
	}

	public function getStep() {
		return $this->getAttribute('step', TRUE);
	}

	public function setStep($value) {
		$this->setAttribute('step', $value);
	}
}

