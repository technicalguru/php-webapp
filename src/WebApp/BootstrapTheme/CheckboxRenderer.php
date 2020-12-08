<?php

namespace WebApp\BootstrapTheme;

class CheckboxRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'checkbox');
		$this->addClass('form-check-input');
	}
}

