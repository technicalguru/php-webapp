<?php

namespace WebApp\DefaultTheme;

class ImageRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		return $this->renderStartTag('img');
	}
}

