<?php

namespace WebApp\Component;

/** Enable/Disable a component when a checkbox is clicked */
abstract class EnableByCheckGroup extends FormElementGroup {

	public function __construct($parent, $id, $label, $checkText, $value = NULL, $inverseCheck = FALSE) {
		parent::__construct($parent, $label);
		$this->setValue($value);
		$this->setId($id.'_checked_group');
		$this->setInverseCheck($inverseCheck);
		$this->addClass('elem-by-check');

		$this->check = new Checkbox($this, $id.'_checked', 'checked');
		$this->check->setLabel($checkText);
		$this->check->setAttribute('data-role', 'dynamic-check-enable');
		$this->input = new Div($this);
		$this->input->setAttribute('data-role', 'dynamic-check-input');
		$this->createInput($this->input, $id, $value);
	}

	public function setInverseCheck($inverseCheck) {
		$this->setAttribute('data-inverse', $inverseCheck ? 'true' : 'false');
	}

	public function setChecked($isChecked) {
		$this->check->setChecked($isChecked);
	}

	public function setValue($value) {
		$this->value = $value;
	}

	public function getValue() {
		return $this->value;
	}

	protected function createInput($parent, $id, $value) {
		new Text('createInput() was not implemented');
	}

}
