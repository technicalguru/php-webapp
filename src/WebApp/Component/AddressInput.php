<?php

namespace WebApp\Component;

use WebApp\DataModel\Address;

class AddressInput extends \WebApp\Component\FormElementGroup {

	public function __construct($parent, $id, $label, $value = NULL) {
		parent::__construct($parent, $label);
		$this->setId($id);
		$this->addClass('form-grid');
		self::createAddressFields($value);
	}

	protected function createAddressFields($address = NULL) {
		if ($address == NULL) $address = new Address();
		$id = $this->getId();

		$elem = new TextInput($this, $id.'_name', $address->street1);
		$elem->setPlaceholder('address_name_label');
		$elem->addClass('mb-1');
		$elem->setRequired(TRUE);

		$elem = new TextInput($this, $id.'_street1', $address->street1);
		$elem->setPlaceholder('address_street1_label');
		$elem->addClass('mb-1');
		$elem->setRequired(TRUE);

		$elem = new TextInput($this, $id.'_street2', $address->street2);
		$elem->setPlaceholder('address_street2_label');
		$elem->addClass('mb-1');

		$flex = new FlexBox($this);
		$item = $flex->createFixedItem()->setStyle('width', '10em')->addClass('mb-1', 'mr-2');
		$elem = new TextInput($item, $id.'_zipCode', $address->zipCode);
		$elem->setPlaceholder('address_zipcode_label');
		$elem->setRequired(TRUE);

		$item = $flex->createItem()->addClass('mb-1');
		$elem = new TextInput($item, $id.'_city', $address->city);
		$elem->setPlaceholder('address_city_label');
		$elem->setRequired(TRUE);

		$elem = new CountrySelect($this, $id.'_country', $address->country);
		$elem->addClass('mb-1');
	}

	public static function fromRequest($id, $request = NULL) {
		if ($request == NULL) $request = \TgUtils\Request::getRequest();
		$rc = NULL;
		if ($request->hasPostParam($id.'_street1')) {
			$rc = new Address();
			$rc->name    = $request->getParam($id.'_name');
			$rc->street1 = $request->getParam($id.'_street1');
			$rc->street2 = $request->getParam($id.'_street2');
			$rc->zipCode = $request->getParam($id.'_zipCode');
			$rc->city    = $request->getParam($id.'_city');
			$rc->country = $request->getParam($id.'_country');
		}
		return $rc;
	}
}
