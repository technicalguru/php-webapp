<?php

namespace WebApp\Component;

class DropDown extends Container {

	public function __construct($parent, $label) {
		parent::__construct($parent);
		$this->button = new Button($this, $label);
		$this->menu = new Div($this);
		$this->button->addClass('btn-secondary');
	}

	public function getButton() {
		return $this->button;
	}

	public function getMenu() {
		return $this->menu;
	}

	public function addLink($link, $label, $target = NULL) {
		return new Link($this->menu, $link, $label, $target);
	}

	public function addDivider() {
		return new Div($this->menu);
	}

}

