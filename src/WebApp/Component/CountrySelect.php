<?php

namespace WebApp\Component;

use TgI18n\I18N;
use WebApp\DataModel\Countries;

class CountrySelect extends Select {

	public function __construct($parent, $id, $value = NULL) {
		parent::__construct($parent, $id, self::createOptions(), $value);
	}

	protected static function createOptions() {
		I18N::addValues(Countries::getTranslations());
		$rc = array();
		foreach (self::getSupportedCountries() AS $country) {
			$rc[$country] = I18N::_($country);
		}
		asort($rc);
		return $rc;
	}

	public static function getSupportedCountries() {
		return Countries::ALL();
	}
}
