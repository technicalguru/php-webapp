<?php

namespace WebApp\Component;

use TgI18n\I18N;

class MonthSelect extends Select {

	protected $options;

	public function __construct($parent, $id, $value = NULL) {
		parent::__construct($parent, $id, $this->createOptions(), $value == NULL ? date('n') - 1 : $value);
	}

	protected function createOptions() {
		return array(
			I18N::_('january'), I18N::_('february'), I18N::_('march'),
			I18N::_('april'),	I18N::_('may'),	I18N::_('june'),
			I18N::_('july'), I18N::_('august'), I18N::_('september'),
			I18N::_('october'), I18N::_('november'), I18N::_('december')
		);
	}

}

