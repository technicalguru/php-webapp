<?php

namespace WebApp\Component;

use TgI18n\I18N;

class DateTimeInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'datetime', $value);
	}

	public function getDate() {
		$value = $this->getValue();
		if (is_object($value)) {
			return $this->getValue()->format(I18N::_('Y-m-d'), TRUE);
		}
		return '';
	}

	public function getTime() {
		$value = $this->getValue();
		if (is_object($value)) {
			return $this->getValue()->format(I18N::_('shortTimeFormat'), TRUE);
		}
		return '';
	}

}


