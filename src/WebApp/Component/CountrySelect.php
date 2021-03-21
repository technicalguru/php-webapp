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

	protected static function getSupportedCountries() {
		return array(
			Countries::AL,
			Countries::AD,
			Countries::AT,
			Countries::BE,
			Countries::BG,
			Countries::HR,
			Countries::CZ,
			Countries::CY,
			Countries::DK,
			Countries::EE,
			Countries::FI,
			Countries::FR,
			Countries::DE,
			Countries::GI,
			Countries::GR,
			Countries::HU,
			Countries::IS,
			Countries::IE,
			Countries::IT,
			Countries::LV,
			Countries::LI,
			Countries::LT,
			Countries::LU,
			Countries::MK,
			Countries::MT,
			Countries::MD,
			Countries::MC,
			Countries::NL,
			Countries::NO,
			Countries::PL,
			Countries::PT,
			Countries::CS,
			Countries::SK,
			Countries::SI,
			Countries::ES,
			Countries::SE,
			Countries::CH,
			Countries::GB,
		);
	}
}
