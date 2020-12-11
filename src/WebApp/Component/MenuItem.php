<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class MenuItem extends Container {

	protected $label;
	protected $pageLink;
	protected $linkTarget;
	protected $icon;

	public function __construct($parent, $label, $pageLink, $icon = NULL) {
		parent::__construct($parent);
		$this->setLabel($label);
		$this->setLinkTarget(NULL);
		$this->setPageLink($pageLink);
		$this->setIcon($icon);
	}

	public function getLabel() {
		return I18N::_($this->label);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function getPageLink() {
		return $this->pageLink;
	}

	public function setPageLink($value) {
		$this->pageLink = $value;
		if ((strlen($value) > 4) && (substr($value, 0,4) == 'http')) {
			$this->setLinkTarget('blank');
		}
	}

	public function getIcon() {
		return $this->icon;
	}

	public function setIcon($value) {
		$this->icon = $value;
	}

	public function getLinkTarget() {
		return $this->linkTarget;
	}

	public function setLinkTarget($value) {
		$this->linkTarget = $value;
	}
}
