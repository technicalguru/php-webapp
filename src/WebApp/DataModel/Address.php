<?php

namespace WebApp\DataModel;

use TgI18n\I18N;
use TgUtils\Utils;

class Address {

	public $name;
	public $street1;
	public $street2;
	public $province;
	public $zipCode;
	public $city;
	public $country;

	public function __construct() {
	}

	public function isComplete() {
		return !Utils::isEmpty($this->street1) && !Utils::isEmpty($this->zipCode) && !Utils::isEmpty($this->city) && !Utils::isEmpty($this->country);
	}

	public static function toSingleLine($address, $language = NULL) {
		$rc = '';
		if (!Utils::isEmpty($address->name))    $rc .= ', '.$address->name;
		if (!Utils::isEmpty($address->country)) $rc .= ', '.I18N::_($address->country, $language);
		if (!Utils::isEmpty($address->province))$rc .= ', '.$address->province;
		if (!Utils::isEmpty($address->city))    $rc .= ', '.$address->city;
		if (!Utils::isEmpty($address->zipCode)) $rc .= ', '.$address->zipCode;
		if (!Utils::isEmpty($address->street1)) $rc .= ', '.$address->street1;
		if (!Utils::isEmpty($address->street2)) $rc .= ', '.$address->street2;
		return substr($rc, 2);
	}
}
