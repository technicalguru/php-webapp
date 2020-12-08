<?php

namespace WebApp\Component;

class MonthInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'month', $value);
	}

}

