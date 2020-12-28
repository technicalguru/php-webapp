<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class FormElement extends Component {

	protected $label;
	protected $help;
	protected $error;

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent);
		$this->setId($id);
		$this->setValue($value);
		$this->setName($id);
	}

	public function getLabel() {
		return I18N::__($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function getHelp() {
		return I18N::__($this->help);
	}

	public function setHelp($value) {
		$this->help = $value;
	}

	public function getError() {
		return I18N::_($this->error);
	}

	public function setError($value) {
		$this->error = $value;
	}

	public function getName() {
		return $this->getAttribute('name', TRUE, $this->getId());
	}

	public function setName($name) {
		$this->setAttribute('name', $name);
	}

	public function getValue() {
		return $this->getAttribute('value', TRUE);
	}

	public function setValue($value) {
		if (is_int($value)) $value = ''.$value;
		$this->setAttribute('value', $value);
	}

	public function isEnabled() {
		return $this->getAttribute('disabled', TRUE) != 'disabled';
	}

	public function setEnabled($b) {
		$this->setAttribute('disabled', $b ? NULL : 'disabled');
	}

	public function isReadOnly() {
		return !$this->isEnabled();
	}

	public function setReadOnly($b) {
		$this->setEnabled(!$b);
	}

	public function isRequired() {
		return $this->getAttribute('required', TRUE) == 'required';
	}

	public function setRequired($b) {
		$this->setAttribute('required', $b ? 'required' : NULL);
	}

}
