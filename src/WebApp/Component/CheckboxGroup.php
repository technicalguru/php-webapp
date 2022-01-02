<?php

namespace WebApp\Component;

class CheckBoxGroup extends FormCheckGroup {

	protected $checkId;

	public function __construct($parent, $id, $values = NULL) {
		parent::__construct($parent, $id.'-group', $values);
		$this->checkId = $id.'[]';
	}

	public function checkbox($label, $value, $checked = FALSE) {
		$rc = new Checkbox($this, $this->checkId, $value);
		$rc->setLabel($label)->setChecked($checked);
		return $rc;
	}
}
