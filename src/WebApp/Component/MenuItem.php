<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class MenuItem extends Container {

	protected $label;
	protected $link;
	protected $linkTarget;
	protected $icon;

	public function __construct($parent, $label, $pageLink, $icon = NULL) {
		parent::__construct($parent);
		$this->setLabel($label);
		$this->setLinkTarget(NULL);
		$this->setLink($pageLink);
		$this->setIcon($icon);
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
		return $this;
	}

	public function setLink($link) {
		$this->link = $link;
		return $this;
	}

	public function getLink() {
		return $this->link;
	}

	public function getPageLink() {
		return $this->getLink();
	}

	public function setPageLink($value) {
		return $this->setLink($value);
	}

	public function getIcon() {
		return $this->icon;
	}

	public function setIcon($value) {
		$this->icon = $value;
		return $this;
	}

	public function getLinkTarget() {
		return $this->linkTarget;
	}

	public function setLinkTarget($value) {
		$this->linkTarget = $value;
		return $this;
	}
}
