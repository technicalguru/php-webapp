<?php

namespace WebApp\BootstrapTheme;

class CombinedFormElementRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-group');
	}

}

