<?php

namespace WebApp\Component;

use TgI18n\I18N;

class Spinner extends Div {

	protected $text;
	protected $type;

	public function __construct($parent, string $text = NULL, string $type = 'primary') {
		parent::__construct($parent);
		$this->text = $text;
		$this->type = $type;
	}

	public function setText($text) {
		$this->text = $text;
	}

	public function getText() {
		if ($this->text != NULL) {
			return I18N::_($this->text);
		}
		return '';
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getType() {
		return $this->type;
	}
}

