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

	public function isComplete($includeName = FALSE) {
		return self::isAddressComplete($this, $includeName);
	}

	public static function isAddressComplete($address, $includeName = FALSE) {
		$rc = !Utils::isEmpty($address->street1) && !Utils::isEmpty($address->zipCode) && !Utils::isEmpty($address->city) && !Utils::isEmpty($address->country);
		if ($rc && $includeName) $rc = isset($address->name) && !Utils::isEmpty($address->name);
		return $rc;
	}

	public static function toSingleLine($address, $language = NULL) {
		$rc = '';
		if (isset($address->name)     && !Utils::isEmpty($address->name))    $rc .= ', '.$address->name;
		if (isset($address->country)  && !Utils::isEmpty($address->country)) $rc .= ', '.I18N::_($address->country, $language);
		if (isset($address->province) && !Utils::isEmpty($address->province))$rc .= ', '.$address->province;
		if (isset($address->city)     && !Utils::isEmpty($address->city))    $rc .= ', '.$address->city;
		if (isset($address->zipCode)  && !Utils::isEmpty($address->zipCode)) $rc .= ', '.$address->zipCode;
		if (isset($address->street1)  && !Utils::isEmpty($address->street1)) $rc .= ', '.$address->street1;
		if (isset($address->street2)  && !Utils::isEmpty($address->street2)) $rc .= ', '.$address->street2;
		return substr($rc, 2);
	}
}
