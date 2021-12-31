<?php

namespace WebApp\Component;

class Button extends Container {

	public function __construct($parent, $text = NULL) {
		parent::__construct($parent, $text);
		$this->setAttribute('type', 'button');
	}

	public function getOnClick() {
		return $this->getAttribute('onclick', TRUE);
	}

	public function setOnClick($onClick) {
		$this->setAttribute('onclick', $onClick);
		return $this;
	}

	public function getType() {
		return $this->getAttribute('type', TRUE);
	}

	public function setType($type) {
		$this->setAttribute('type', $type);
		return $this;
	}

	public function getName() {
		return $this->getAttribute('name', TRUE);
	}

	public function setName($name) {
		$this->setAttribute('name', $name);
		return $this;
	}

	public function getValue() {
		return $this->getAttribute('value', TRUE);
	}

	public function setValue($value) {
		$this->setAttribute('value', $value);
		return $this;
	}

	public function getEnabled() {
		return $this->getAttribute('disabled', TRUE) != 'disabled';
	}

	public function setEnabled($value) {
		if ($value) {
			$this->removeAttribute('disabled');
		} else {
			$this->setAttribute('disabled', 'disabled');
		}
		return $this;
	}

}

