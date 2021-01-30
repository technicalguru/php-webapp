<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class BasicFormElement extends Component {

	protected $label;
	protected $help;

	public function __construct($parent, $id) {
		parent::__construct($parent);
		$this->setId($id);
		$this->setName($id);
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function getHelp() {
		return I18N::_($this->help);
	}

	public function setHelp($value) {
		$this->help = $value;
	}

	public function getName() {
		return $this->getAttribute('name', TRUE, $this->getId());
	}

	public function setName($name) {
		$this->setAttribute('name', $name);
	}

	public function getBaseName() {
		$rc = $this->getName();
		if (strpos($this->getName(), '[]') > 0) {
			$rc = substr($rc, 0, strlen($rc)-2);
		}
		return $rc;
	}

	public function isArray() {
		return strpos($this->getName(), '[]') > 0;
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
