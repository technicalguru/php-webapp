<?php

namespace WebApp\Component;

class EmailInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'email', $value);
	}

}

