<?php

namespace WebApp\Component;

use TgI18n\I18N;

/** A single tab in a TabSet */ 
class Tab extends Container {

	public $label;
	public $active;
	protected $navLinkClasses;
	protected $tabPaneClasses;

	public function __construct($parent, $id, $label, $content = NULL) {
		parent::__construct($parent, $content);
		$this->setId($id);
		$this->setLabel($label);
		$this->navLinkClasses = array();
		$this->tabPaneClasses = array();
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function setActive($value) {
		$this->active = $value;
	}

	public function isActive() {
		return $this->active;
	}

	public function addNavLinkClass($class) {
		if (!in_array($class, $this->navLinkClasses)) $this->navLinkClasses[] = $class;
	}

	public function removeNavLinkClass($class) {
		$newClasses = array();
		foreach ($this->navLinkClasses AS $c) {
			if ($class != $c) $classes = $c;
		}
		$this->navLinkClasses = $newClasses;
	}

	public function getNavLinkClasses() {
		return $this->navLinkClasses;
	}

	public function addTabPaneClass($class) {
		if (!in_array($class, $this->tabPaneClasses)) $this->tabPaneClasses[] = $class;
	}

	public function removeTabPaneClass($class) {
		$newClasses = array();
		foreach ($this->tabPaneClasses AS $c) {
			if ($class != $c) $classes = $c;
		}
		$this->tabPaneClasses = $newClasses;
	}

	public function getTabPaneClasses() {
		return $this->tabPaneClasses;
	}
}
