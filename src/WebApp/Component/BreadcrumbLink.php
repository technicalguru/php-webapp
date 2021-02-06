<?php

namespace WebApp\Component;

class BreadcrumbLink extends Component {

	protected $label;
	protected $link;
	protected $active;

	public function __construct($parent, $label, $link, $isActive) {
		parent::__construct($parent);
		$this->setLabel($label);
		$this->setLink($link);
		$this->setActive($isActive);
	}

	public function setLabel($value) {
		$this->label = $value;
	}

	public function getLabel() {
		return $this->label;
	}

	public function setLink($value) {
		$this->link = $value;
	}

	public function getLink() {
		return $this->link;
	}

	public function setActive($value) {
		$this->active = $value;
	}

	public function isActive() {
		return $this->active;
	}

}

