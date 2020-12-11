<?php

namespace WebApp\Component;

class Wrapper extends Container {

	protected $before;
	protected $after;

	public function __construct($parent, $before, $after) {
		parent::__construct($parent);
		$this->before = $before;
		$this->after  = $after;
	}

	public function getBefore() {
		return $this->before;
	}

	public function setBefore($before) {
		$this->before = $before;
	}

	public function getAfter() {
		return $this->after;
	}

	public function setAfter($after) {
		$this->after = $after;
	}

}

