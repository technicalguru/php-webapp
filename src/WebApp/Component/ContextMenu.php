<?php

namespace WebApp\Component\Data;

/**
  * Usage (with LinkBuilder or LinkBuilderService): 
  *   $menu   = new ContextMenu($app, $dataObject, $linkBuilderService);
  *   $group1 = $menu->createGroup();
  *   $item1  = $group1->createItem('View this object')->setAction('view');
  *   $item2  = $group1->createItem('Edit this object')->setAction('edit');
  *   
  * Usage (without LinkBuilder or LinkBuilderService): 
  *   $menu   = new ContextMenu($app, $dataObject);
  *   $group1 = $menu->createGroup();
  *   $item1  = $group1->createItem('View this object')->setLink('/path/to/view.html');
  *   $item2  = $group1->createItem('Edit this object')->setLink('/path/to/edit.html');
  * 
  * You can also give a label to the group:
  *   $group1 = $menu->createGroup('Actions');
  *
  * It is recommended to subclass ContextMenu and populate the menu after calling the parent
  * constructor.
  *
  * Use the context menu with DropDown (the context menu must be complete at this time):
  *   $dropDown->setMenu($menu);
  */
class ContextMenu extends Div {

	protected $app;
	protected $subject;
	protected $groups;
	protected $linkBuilder;

	public function __construct($parent, $app, $subject, $linkBuilder = NULL) {
		parent::__construct($parent);
		$this->app     = $app;
		$this->subject = $subject;
		$this->groups  = array();
		if ($linkBuilder != NULL) {
			if (is_a($linkBuilder, 'WebApp\\Service\\LinkBuilderService')) {
				$this->linkBuilder = $linkBuilder->getBuilder($subject);
			} else {
				$this->linkBuilder = $linkBuilder;
			}
		}
	}

	public function createGroup($label = NULL) {
		$rc = new ContextMenuGroup($this, $this->app, $this->subject, $label);
		$rc->setLinkBuilder($this->linkBuilder);
		$this->groups[] = $rc;
		return $rc;
	}

	public function getMenu() {
		return $this->groups;
	}

}
