<?php

namespace WebApp\BootstrapTheme;

class MainContentRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('container-fluid');
	}
}

