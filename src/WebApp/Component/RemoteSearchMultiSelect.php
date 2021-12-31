<?php

namespace WebApp\Component;

class RemoteSearchMultiSelect extends BasicFormElement {

	public $restUri;
	public $values;
	public $fixedValues;

	public function __construct($parent, $id, $restUri, $values = null) {
		parent::__construct($parent, $id);
		$this->restUri     = $restUri;
		$this->values      = is_array($values) ? $values : array();
		$this->fixedValues = array();
	}

	public function getPlaceholder() {
		return $this->getAttribute('placeholder', TRUE);
	}

	public function setPlaceholder($placeholder) {
		$this->setAttribute('placeholder', \TgI18n\I18N::__($placeholder));
	}

}

