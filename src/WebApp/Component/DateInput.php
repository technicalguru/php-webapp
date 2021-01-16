<?php

namespace WebApp\Component;

use TgI18n\I18N;

class DateInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'date', $value);
		if (is_object($value)) {
			$this->setValue($value->format(I18N::_('dateFormat'), TRUE));
		}
	}

}

