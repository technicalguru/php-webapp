<?php

namespace WebApp\Component;

class Select extends BasicFormElement {

	protected $options;

	public function __construct($parent, $id, $options = array(), $value = null) {
		parent::__construct($parent, $id, $value);
		$this->options     = $options;
		$this->emptyOption = NULL;
	}

	public function setEmptyOption($value) {
		$this->emptyOption = $value;
	}

	public function getEmptyOption() {
		return $this->emptyOption;
	}

	public function getOptions() {
		return $this->options;
	}

	public function setOptions($options) {
		$this->options = $options;
	}
}

