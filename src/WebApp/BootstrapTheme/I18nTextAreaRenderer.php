<?php

namespace WebApp\BootstrapTheme;

class I18nTextAreaRenderer extends I18nFormElementRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	protected function createFormElement($languageKey, $id) {
		return new \WebApp\Component\TextArea(NULL, $id, $this->component->getValue($languageKey));
	}
}
