<?php

namespace WebApp\Component;

/** A single tab in a TabSet */ 
class TabSet extends Container {

	protected $navLinkClasses;
	protected $tabPaneClasses;

	public function __construct($parent, $id = NULL) {
		parent::__construct($parent);
		if ($id != NULL) $this->setId($id);
		$this->addClass('pt-4');
		$this->addClass('pb-4');
		$this->navLinkClasses = array();
		$this->tabPaneClasses = array();
	}

	public function createTab($id, $label, $content = NULL) {
		return new Tab($this, $id, $label, $content);
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
