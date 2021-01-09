<?php

namespace WebApp\Component;

class SubmitButton extends Button {

	public function __construct($parent, $text = NULL, $name = NULL, $value = NULL) {
		parent::__construct($parent, $text);
		$this->setAttribute('type', 'submit');
		if ($name != NULL) $this->setName($name);
		if ($value != NULL) $this->setValue($value);
	}

}

