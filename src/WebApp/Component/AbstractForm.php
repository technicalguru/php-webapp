<?php

namespace WebApp\Component;

abstract class AbstractForm extends Container {

	protected $fieldSets;

	public function __construct($parent, $id) {
		parent::__construct($parent);
		$this->setId($id);
		$this->fieldSets = array();
	}

	public function addChild($child) {
		parent::addChild($child);
		if (is_a($child, 'WebApp\\Component\\FieldSet')) {
			$this->fieldSets[] = $child;
		}
		return $this;
	}

	public function getFieldSets() {
		return $this->fieldSets;
	}

	public function hasFieldSets() {
		return count($this->fieldSets) > 0;
	}

	public function setMethod($method) {
		$this->setAttribute('method', $method);
		return $this;
	}

	public function getMethod() {
		return $this->getAttribute('method', TRUE);
	}

	public function setAction($action) {
		$this->setAttribute('action', $action);
		return $this;
	}

	public function getAction() {
		return $this->getAttribute('action', TRUE);
	}

	public function setEncoding($encoding) {
		$this->setAttribute('enctype', $encoding);
		return $this;
	}

	public function getEncoding() {
		return $this->getAttribute('enctype', TRUE);
	}

}

