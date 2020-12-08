<?php

namespace WebApp\Component;

class Form extends Container {

	public const VERTICAL   = 'vertical';
	public const HORIZONTAL = 'horizontal';
	public const GRID       = 'grid';
	public const INLINE     = 'inline';

	protected $type;

	public function __construct($parent, $id, $type = Form::VERTICAL) {
		parent::__construct($parent);
		$this->type = $type;
		$this->setId($id);
	}

	public function getType() {
		return $this->type;
	}

	public function setMethod($method) {
		$this->setAttribute('method', $method);
	}

	public function getMethod() {
		return $this->getAttribute('method', TRUE);
	}

	public function setAction($action) {
		$this->setAttribute('action', $action);
	}

	public function getAction() {
		return $this->getAttribute('action', TRUE);
	}

	public function setEncoding($encoding) {
		$this->setAttribute('enctype', $encoding);
	}

	public function getEncoding() {
		return $this->getAttribute('enctype', TRUE);
	}

}

