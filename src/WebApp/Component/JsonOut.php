<?php

namespace WebApp\Component;

class JsonOut extends Preformatted {

	public function __construct($parent, $object) {
		parent::__construct($parent, json_encode($object, JSON_PRETTY_PRINT));
	}

}

