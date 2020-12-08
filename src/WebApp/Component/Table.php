<?php

namespace WebApp\Component;

class Table extends Container {

	public $header;
	public $body;

	public function __construct($parent) {
		parent::__construct($parent);
	}

	public function getHeader($create = TRUE) {
		if ($create && $this->header == NULL) {
			$this->header = new TableHeader($this);
		}
		return $this->header;
	}
 
	public function getBody($create = TRUE) {
		if ($create && $this->body == NULL) {
			$this->body = new TableBody($this);
		}
		return $this->body;
	}
 
	public function createRow($headerRow = FALSE) {
		if ($headerRow) {
			return $this->getHeader()->createRow();
		}
		return $this->getBody()->createRow();
	}
	
}

