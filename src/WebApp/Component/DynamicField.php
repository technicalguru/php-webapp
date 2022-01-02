<?php

namespace WebApp\Component;

class DynamicField extends CombinedFormElement {

	public function __construct($parent, $id, $values = NULL) {
		parent::__construct($parent, $id, $values);
		new \WebApp\Component\HiddenInput($this, $id.'-id', 'IDNUM');
	}

	public function setValues($values) {
		$this->values = is_array($values) ? $values : array();
	}
}

