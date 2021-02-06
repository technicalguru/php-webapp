<?php

namespace WebApp\Component;

class Breadcrumb extends Container {

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function addLink($label, $link = NULL) {
		return new BreadcrumbLink($this, $label, $link, $link == NULL);
	}
	
}

