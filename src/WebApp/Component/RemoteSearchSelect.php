<?php

namespace WebApp\Component;

class RemoteSearchSelect extends BasicFormElement {

	public $restUri;

	public function __construct($parent, $id, $restUri, $value = null) {
		parent::__construct($parent, $id, $value);
		$this->restUri = $restUri;
	}

	public function getPlaceholder() {
		return $this->getAttribute('placeholder', TRUE);
	}

	public function setPlaceholder($placeholder) {
		$this->setAttribute('placeholder', \TgI18n\I18N::__($placeholder));
	}

}

