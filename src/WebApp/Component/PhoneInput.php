<?php

namespace WebApp\Component;

class PhoneInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'tel', $value);
	}

}

