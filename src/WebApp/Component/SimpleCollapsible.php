<?php

namespace WebApp\Component;

class SimpleCollapsible extends Div {

	public function __construct($parent, $toggleText = NULL) {
		parent::__construct($parent);
		$this->toggleDiv = new Div($this);
		$this->body      = new Div($this);
		$this->body->addClass('collapse', 'multi-collapse');
		$this->addToggleButton($toggleText);
		$this->addClass('simple-collapsible');
	}

	public function getToggleDiv() {
		return $this->toggleDiv;
	}

	public function getToggleLink() {
		return $this->link;
	}

	public function getBody() {
		return $this->body;
	}

	protected function addToggleButton($toggleText) {
		$this->link = new Link($this->toggleDiv, '#'.$this->body->getId(), $toggleText);
		$this->link
			->setData('toggle', 'collapse')
			->setAria('expanded', 'false')
			->setAria('controls', $this->body->getId());
	}
}

