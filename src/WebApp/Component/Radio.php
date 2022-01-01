<?php

namespace WebApp\Component;

class Radio extends Input {

	protected $labelClasses;

	public function __construct($parent, $id, $value) {
		parent::__construct($parent, $id, 'radio', $value);
		$this->labelClasses = array();
	}

	public function setChecked($value) {
		$this->setAttribute('checked', $value ? 'checked' : NULL);
	}

	public function isChecked() {
		return $this->getAttribute('checked', TRUE) == 'checked';
	}

	public function getLabelClass() {
		return implode(' ', $this->labelClasses);
	}

	public function addLabelClass(...$classes) {
		foreach ($classes AS $class) {
			$this->labelClasses[] = $class;
		}
		return $this;
	}

	public function removeLabelClass($class) {
		$new = array();
		foreach ($this->labelClasses AS $c) {
			if ($c != $class) $new[] = $c;
		}
		$this->labelClasses = $new;
		return $this;
	}

	public function hasLabelClass($class) {
		return in_array($class, $this->labelClasses);
	}

}
}

