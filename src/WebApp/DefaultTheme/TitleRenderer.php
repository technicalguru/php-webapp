<?php

namespace WebApp\DefaultTheme;

class TitleRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'h1');
		$this->addClass('title');
	}
}

