<?php

namespace WebApp\DefaultTheme;

class TextRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc = $this->component->getText();
		if (count($this->component->getAttributes()) || count($this->component->getStyles())) {
			$rc = $this->renderStartTag('span').$rc.$this->renderEndTag('span');
		}
		return $rc;
	}
}

