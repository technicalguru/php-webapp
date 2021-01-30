<?php

namespace WebApp\Component;

class DynamicField extends Container {

	public function __construct($parent, $id, $values = NULL) {
		parent::__construct($parent);
		$this->setId($id);
		$this->setValues($values);
		 new \WebApp\Component\HiddenInput($this, $id.'-id', 'IDNUM');
	}

	public function getValues() {
		return $this->values;
	}

	public function setValues($values) {
		$this->values = is_array($values) ? $values : array();
	}
}

