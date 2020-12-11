<?php

namespace WebApp\Component;

class SearchInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'search', $value);
	}

}

