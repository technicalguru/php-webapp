<?php

namespace WebApp\Component;

use TgUtils\FormatUtils;

class PriceInput extends NumberInput {

	public function __construct($parent, $id, $value = null, $currency = NULL) {
		parent::__construct($parent, $id, FormatUtils::formatPrice($value != NULL ? $value : 0, '', NULL, ''));
		$this->setStep(0.01);
		$this->setMin(0);
		$this->currency = $currency;
	}

	public function getCurrency() {
		return $this->currency;
	}

	public function setCurrency($value) {
		$this->currency = $value;
		return $this;
	}

}

