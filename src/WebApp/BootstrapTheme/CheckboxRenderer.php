<?php

namespace WebApp\BootstrapTheme;

class CheckboxRenderer extends \WebApp\DefaultTheme\CheckboxRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		if (!$this->component->getAnnotation('bootstrap/no-class')) {
			$this->addClass('form-check-input');
		}
	}

}

