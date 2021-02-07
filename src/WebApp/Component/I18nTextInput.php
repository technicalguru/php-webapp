<?php

namespace WebApp\Component;

class I18nTextInput extends I18nFormElement {

	protected $placeholder;

	public function __construct($parent, $id, $languages, $values) {
		parent::__construct($parent, $id, $languages, $values);
	}

	public function getPlaceholder() {
		return $this->placeholder;
	}

	public function setPlaceholder($placeholder) {
		$this->placeholder = $placeholder;
	}

}
