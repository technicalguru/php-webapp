<?php

namespace WebApp\Component;

class InfoField extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'text', $value);
		$this->setEnabled(FALSE);
	}

}

