<?php

namespace WebApp\Component;

class CombinedFormElement extends FormElement {

	protected $values;
	protected $errors;

	public function __construct($parent, $id, $values = NULL) {
		parent::__construct($parent, $id);
		$this->setValues($values);
	}

	public function setValues($values) {
		$this->values = $values;
		return $this;
	}

	public function getValues($values) {
		return $this->values;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setErrors($values) {
		$this->errors = $values;
	}

}

