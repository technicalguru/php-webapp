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
		return $this;
	}

	public function getType() {
		return $this->getAttribute('type', TRUE, 'text');
	}

	public function setType($type) {
		$this->setAttribute('type', $type);
		return $this;
	}

	public function setPrependContent($value) {
		$this->prependContent = $value;
		return $this;
	}

	public function getPrependContent() {
		return $this->prependContent;
	}

	public function setAppendContent($value) {
		$this->appendContent = $value;
		return $this;
	}

	public function getAppendContent() {
		return $this->appendContent;
	}

}

