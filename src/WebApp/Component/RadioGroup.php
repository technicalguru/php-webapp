<?php

namespace WebApp\Component;

class RadioGroup extends FormCheckGroup {

	protected $checkId;

	public function __construct($parent, $id, $values = NULL) {
		parent::__construct($parent, $id.'-group', $values);
		$this->checkId = $id;
	}

	public function radio($label, $value, $checked = FALSE) {
		$rc = new Radio($this, $this->checkId, $value);
		$rc->setLabel($label)->setChecked($checked);
		return $rc;
	}
}
