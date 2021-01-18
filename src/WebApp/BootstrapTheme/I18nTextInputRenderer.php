<?php

namespace WebApp\BootstrapTheme;

class I18nTextInputRenderer extends I18nFormElementRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	protected function createFormElement($languageKey, $id) {
		$rc = new \WebApp\Component\TextInput(NULL, $id, $this->component->getValue($languageKey));
		$rc->setEnabled($this->component->isEnabled());
		$rc->setRequired($this->component->isRequired());
		return $rc;
	}
}
