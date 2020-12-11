<?php

namespace WebApp\Component;

class HiddenInput extends Input {

	public function __construct($parent, $id, $value) {
		parent::__construct($parent, $id, 'hidden', $value);
	}

}

