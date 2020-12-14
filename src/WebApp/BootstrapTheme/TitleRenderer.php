<?php

namespace WebApp\BootstrapTheme;

class TitleRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'h1');
		$this->addClass('display-4');
	}
}

