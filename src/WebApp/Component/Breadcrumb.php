<?php

namespace WebApp\Component;

class Breadcrumb extends Container {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function addLink($label, $link, $target = NULL) {
		return new Link($this, $link, $label, $target);
	}
	
}

