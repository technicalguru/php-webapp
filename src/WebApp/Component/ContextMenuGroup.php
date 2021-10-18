<?php

namespace WebApp\Component;

class ContextMenuGroup extends ContextMenuItem {

	protected $items;

	public function __construct($parent, $app, $subject, $label = NULL) {
		parent::__construct($parent, $app, $subject, $label);
		$this->items   = array();
	}

	public function createGroup($label = NULL) {
		$rc = new ContextMenuGroup($this->parent, $this->app, $this->subject, $label);
		$rc->setLinkBuilder($this->linkBuilder);
		$this->items[] = $rc;
		return $rc;
	}

	public function createItem($label = NULL) {
		$rc = new ContextMenuItem($this->parent, $this->app, $this->subject, $label);
		$rc->setLinkBuilder($this->linkBuilder);
		$this->items[] = $rc;
		return $rc;
	}

}
