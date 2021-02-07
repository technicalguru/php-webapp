<?php

namespace WebApp\Component;

class Heading extends Container {

	protected $level;

	public function __construct($parent, $level, $content = NULL) {
		parent::__construct($parent, $content);
		$this->level = $level;
	}

	public function getLevel() {
		return $this->level;
	}
}

