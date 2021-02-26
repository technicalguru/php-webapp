<?php

namespace WebApp\Component;

class InputGroup extends FormElement {

	public function __construct($parent, $label) {
		parent::__construct($parent, NULL);
		$this->setLabel($label);
		$this->setGroup(TRUE);
		$this->addClass('input-group');
	}

	public function setPrepend($prepend) {
		$this->prepend = $prepend;
		return $this;
	}

	public function getPrepend() {
		return $this->prepend;
	}

	public function setAppend($append) {
		$this->append = $append;
		return $this;
	}

	public function getAppend() {
		return $this->append;
	}

}

