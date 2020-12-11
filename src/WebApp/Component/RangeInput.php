<?php

namespace WebApp\Component;

class RangeInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'range', $value);
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

	public function isHorizontal() {
		return !$this->isVertical();
	}

	public function isVertical() {
		return $this->getAttribute('orient', TRUE) == 'vertical';
	}

	public function setHorizontal($value) {
		$this->setVertical(!$value);
	}

	public function setVertical($value) {
		$this->setAttribute('orient', $value ? 'vertical' : NULL);
	}
}

