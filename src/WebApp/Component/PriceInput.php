<?php

namespace WebApp\Component;

class PriceInput extends NumberInput {

	public function __construct($parent, $id, $value = null, $currency = NULL) {
		parent::__construct($parent, $id, $value != NULL ? sprintf('%01.2f', $value) : '0.00');
		$this->currency = $currency;
		$this->setStep(0.01);
		$this->setMin(0);
	}

	public function getCurrency() {
		return $this->currency;
	}

	public function setCurrency($value) {
		$this->currency = $value;
	}
}

