<?php

namespace WebApp\DefaultTheme;

class PreformattedRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		return $this->renderStartTag('pre').
		       $this->component->getText().
		       $this->renderEndTag('pre');
	}
}

