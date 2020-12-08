<?php

namespace WebApp\DefaultTheme;

class TextAreaRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$value = $this->component->getValue();
		if ($value == NULL) $value = '';
		return $this->renderStartTag('textarea').
		       htmlentities($value).
		       $this->renderEndTag('textarea');
	}
}

