<?php

namespace WebApp\Component;

class Checkbox extends FormCheck {

	public function __construct($parent, $id, $value) {
		parent::__construct($parent, $id, 'checkbox', $value);
	}

}

