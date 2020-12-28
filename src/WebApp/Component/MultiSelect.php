<?php

namespace WebApp\Component;

class MultiSelect extends FormElement {

	protected $options;
	protected $values;

	public function __construct($parent, $id, $options = array(), $values = null) {
		parent::__construct($parent, $id);
		$this->options = $options;
		$this->setValues($values);
	}

	public function getOptions() {
		return $this->options;
	}

	public function setOptions($options) {
		$this->options = $options;
	}

	public function getValues() {
		return $this->values;
	}

	public function setValues($values) {
		$this->values = is_array($values) ? $values : array();
	}
}

