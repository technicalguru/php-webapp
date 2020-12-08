<?php

namespace WebApp\Component;

class WeekInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'week', $value);
	}

}

