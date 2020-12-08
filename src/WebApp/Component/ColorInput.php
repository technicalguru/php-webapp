<?php

namespace WebApp\Component;

class ColorInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'color', $value);
	}

}

