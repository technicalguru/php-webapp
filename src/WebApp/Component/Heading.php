<?php

namespace WebApp\Component;

class Heading extends Container {

	protected $level;

	public function __construct($parent, $level, string $text = NULL) {
		parent::__construct($parent, $text);
		$this->level = $level;
	}

	public function getLevel() {
		return $this->level;
	}
}

