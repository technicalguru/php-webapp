<?php

namespace WebApp\Component;

abstract class FormCheck extends Input {

	protected $labelClasses;
	protected $inline;

	public function __construct($parent, $id, $type, $value) {
		parent::__construct($parent, $id, $type, $value);
		$this->labelClasses = array();
		$this->inline       = FALSE;
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

	public function isInline() {
		return $this->inline;
	}

	public function setInline($value) {
		$this->inline = $value;
		return $this;
	}
}

