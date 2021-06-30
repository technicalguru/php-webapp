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

	public static function getPostValue($name, $timezoneId) {
		$request = \TgUtils\Request::getRequest();
		$date    = $request->getPostParam($name.'-date');
		if ($date != NULL) {
			$rc = \TgUtils\Date::createFromFormat('Y-m-d H:i', $date.' 00:00', $timezoneId);
			if ($rc !== FALSE) return $rc;
		}
		return NULL;
	}
}

