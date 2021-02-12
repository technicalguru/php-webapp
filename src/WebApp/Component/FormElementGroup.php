<?php

namespace WebApp\Component;

class FormElementGroup extends FormElement {

	public function __construct($parent, $label) {
		parent::__construct($parent, NULL);
		$this->setLabel($label);
		$this->setGroup(TRUE);
	}

}

