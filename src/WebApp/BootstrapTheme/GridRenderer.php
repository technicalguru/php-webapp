<?php

namespace WebApp\BootstrapTheme;

class GridRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		if (!$component->hasClass('container-fluid')) {
			$this->addClass('container');
		}
	}
}

