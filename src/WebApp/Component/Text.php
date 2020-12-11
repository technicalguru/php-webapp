<?php

namespace WebApp\Component;

use TgI18n\I18N;

class Text extends Component {

	protected $text;

	public function __construct($parent, string $text = NULL) {
		parent::__construct($parent);
		$this->text = $text;
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

}

