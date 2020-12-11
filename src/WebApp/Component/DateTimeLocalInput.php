<?php

namespace WebApp\Component;

class DateTimeLocalInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'datetime-local', $value);
	}

}


