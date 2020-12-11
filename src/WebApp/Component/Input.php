<?php

namespace WebApp\Component;

class Input extends FormElement {

	public function __construct($parent, $id, $type = 'text', $value = null) {
		parent::__construct($parent, $id, $value);
		$this->setType($type);
	}

	public function getPlaceholder() {
		return $this->getAttribute('placeholder', TRUE);
	}

	public function setPlaceholder($placeholder) {
		$this->setAttribute('placeholder', \TgI18n\I18N::__($placeholder));
	}

	public function getType() {
		return $this->getAttribute('type', TRUE, 'text');
	}

	public function setType($type) {
		$this->setAttribute('type', $type);
	}

}

