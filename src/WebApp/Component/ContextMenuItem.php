<?php

namespace WebApp\Component;

class ContextMenuItem extends MenuItem {

	protected $app;
	protected $subject;
	protected $linkBuilder;

	public function __construct($parent, $app, $subject, $label = NULL) {
		parent::__construct($parent, $label);
		$this->app     = $app;
		$this->subject = $subject;
	}

	public function setLinkBuilder($linkBuilder) {
		$this->linkBuilder = $linkBuilder;
	}

	public function getLinkBuilder() {
		return $this->linkBuilder;
	}

	public function setAction($action = \TgUtils\LinkBuilder::VIEW, $params = NULL) {
		if ($this->linkBuilder != NULL) {
			$this->setLink($linkBuilder->getLink($this->subject, $action, $params));
		} else {
			$this->setLink('#'.$action);
		}
		return $this;
	}

}
