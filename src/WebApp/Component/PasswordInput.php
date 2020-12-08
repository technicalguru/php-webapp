<?php

namespace WebApp\Component;

class PasswordInput extends Input {

	public function __construct($parent, $id) {
		parent::__construct($parent, $id, 'password');
	}

}

