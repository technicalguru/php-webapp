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

	public static function getPostValue($name, $timezoneId) {
		$request = \TgUtils\Request::getRequest();
		$date    = $request->getPostParam($name.'-date');
		$time    = $request->getPostParam($name.'-time');
		if ($date != NULL) {
			if ($time == NULL) $time = '00:00';
			return \TgUtils\Date::createFromFormat('Y-m-d H:i', $date.' '.$time, $timezoneId);
		}
		return NULL;
	}
}


