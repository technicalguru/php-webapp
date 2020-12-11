<?php

namespace WebApp\Component;

class TableCell extends Container {

	protected $heading;

	public function __construct($parent, $text = NULL, $isHeading = FALSE) {
		parent::__construct($parent, $text);
		$this->heading = $isHeading;
	}

	public function getColSpan() {
		return $this->getAttribute('colspan', TRUE, 1);
	}

	public function setColSpan($colspan) {
		$this->setAttribute('colspan', $colspan);
	}

	public function getRowSpan() {
		return $this->getAttribute('rowspan', TRUE, 1);
	}

	public function setRowSpan($rowspan) {
		$this->setAttribute('rowspan', $rowspan);
	}

	public function setHeading($heading = TRUE) {
		$this->heading = $heading;
	}

	public function isHeading() {
		return $this->heading;
	}

}

