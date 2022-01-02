<?php

namespace WebApp\Component;

class Radio extends FormCheck {

	public function __construct($parent, $id, $value) {
		parent::__construct($parent, $id, 'radio', $value);
	}

}

