<?php

namespace WebApp\DataModel;

use TgUtils\Utils;

class Address {

	public $street1;
	public $street2;
	public $zipCode;
	public $city;
	public $country;

	public function __construct() {
	}

	public function isComplete() {
		return !Utils::isEmpty($this->street1) && !Utils::isEmpty($this->zipCode) && !Utils::isEmpty($this->city) && !Utils::isEmpty($this->country);
	}

}
