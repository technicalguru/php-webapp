<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class BasicFormElement extends Container {

	protected $label;
	protected $help;
	protected $group;
	protected $hidden;

	public function __construct($parent, $id) {
		parent::__construct($parent);
		if ($id != NULL) {
			$this->setId($id);
			$this->setName($id);
		}
		$this->group  = FALSE;
		$this->hidden = FALSE;
	}

	public function hide() {
		$this->hidden = TRUE;
	}

	public function show() {
		$this->hidden = FALSE;
	}

	public function isHidden() {
		return $this->hidden;
	}

	public function isGroup() {
		return $this->group;
	}

	public function setGroup($value) {
		$this->group = $value;
		return $this;
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
		return $this;
	}

	public function getHelp() {
		return I18N::_($this->help);
	}

	public function setHelp($value) {
		$this->help = $value;
		return $this;
	}

	public function getName() {
		return $this->getAttribute('name', TRUE, $this->getId());
	}

	public function setName($name) {
		$this->setAttribute('name', $name);
		return $this;
	}

	public function getBaseName() {
		$rc = $this->getName();
		if (mb_strpos($this->getName(), '[]') > 0) {
			$rc = mb_substr($rc, 0, mb_strlen($rc)-2);
		}
		return $rc;
	}

	public function isArray() {
		return mb_strpos($this->getName(), '[]') > 0;
	}

	public function isEnabled() {
		return $this->getAttribute('disabled', TRUE) != 'disabled';
	}

	public function setEnabled($b) {
		$this->setAttribute('disabled', $b ? NULL : 'disabled');
		return $this;
	}

	public function isReadOnly() {
		return !$this->isEnabled();
	}

	public function setReadOnly($b) {
		$this->setEnabled(!$b);
		return $this;
	}

	public function isRequired() {
		return $this->getAttribute('required', TRUE) == 'required';
	}

	public function setRequired($b) {
		$this->setAttribute('required', $b ? 'required' : NULL);
		return $this;
	}

}
