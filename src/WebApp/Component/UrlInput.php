<?php

namespace WebApp\Component;

class UrlInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'url', $value);
	}

}

