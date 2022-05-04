<?php

namespace WebApp\Component;

use TgI18n\I18N;
use TgUtils\Date;
use TgUtils\DateRange;

class DateRangeInput extends Input {

	protected $showDropdowns       = TRUE;
	protected $alwaysShowCalendars = TRUE;

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'text', NULL);
		$this->period = $value;
		$this->setPrependContent('<i class="fas fa-calendar-alt"></i>');
	}

	public function showDropdowns($newValue = NULL) {
		if ($newValue == NULL) return $this->showDropdowns;
		else $this->showDropdowns = $newValue;
		return $this;
	}

	public function alwaysShowCalendars($newValue = NULL) {
		if ($newValue == NULL) return $this->alwaysShowCalendars;
		else $this->alwaysShowCalendars = $newValue;
		return $this;
	}

	public function setRange($value) {
		$this->period = $value;
		return $this;
	}

	public function getRange() {
		if ($this->period == NULL) $this->period = new DateRange();
		return $this->period;
	}

	public function setOnApply($script) {
		$this->setData('apply-script', $script);
		return $this;
	}

	public static function getGetValue($name, $timezoneId) {
		$request = \TgUtils\Request::getRequest();
		$range   = $request->getGetParam($name);
		return self::fromString($range);
	}

	public static function getPostValue($name, $timezoneId) {
		$request = \TgUtils\Request::getRequest();
		$range   = $request->getPostParam($name);
		return self::fromString($range);
	}

	public static function fromString($range) {
		if ($range != NULL) {
			list($fromS, $untilS) = explode(' - ', $range, 2);
			$from  = Date::createFromFormat(I18N::_('daterange_internal_format').' H:i:s', $fromS.' 00:00:00', $timezoneId);
			$until = Date::createFromFormat(I18N::_('daterange_internal_format').' H:i:s', $untilS.' 23:59:59', $timezoneId);

			return new DateRange($from, $until);
		}
		return NULL;
	}

}

