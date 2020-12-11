<?php

namespace WebApp\Component;

class Select extends FormElement {

	protected $options;

	public function __construct($parent, $id, $options = array(), $value = null) {
		parent::__construct($parent, $id, $value);
		$this->options = $options;
	}

	public function getOptions() {
		return $this->options;
	}

	public function setOptions($options) {
		$this->options = $options;
	}
}

