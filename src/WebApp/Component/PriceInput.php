<?php

namespace WebApp\Component;

use TgUtils\FormatUtils;

class PriceInput extends InputGroup {

	public function __construct($parent, $id, $value = null, $currency = NULL) {
		parent::__construct($parent, NULL);
		$this->setId('input-group-'.$id);
		$this->input = new NumberInput($this, $id, FormatUtils::formatPrice($value != NULL ? $value : 0, '', NULL, ''));
		$this->input->setStep(0.01);
		$this->input->setMin(0);
		$this->currency = $currency;
		$this->currencyElem = new Text(NULL, $this->currency);
		$this->currencyElem->addClass('input-group-text');
		$this->setPrepend($this->currencyElem);
	}

	public function getCurrency() {
		return $this->currency;
	}

	public function setCurrency($value) {
		$this->currency = $value;
		return $this;
	}

	public function getInput() {
		return $this->input;
	}

	public function setName($name) {
		$this->input->setName($name);
		return $this;
	}

	public function getName() {
		return $this->input->getName();
	}

	public function setValue($value) {
		if ($this->input != NULL) {
			$this->input->setValue($value);
		}
		return $this;
	}

	public function getValue() {
		return $this->input->getValue();
	}
}

