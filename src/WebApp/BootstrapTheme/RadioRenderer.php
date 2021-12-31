<?php

namespace WebApp\BootstrapTheme;

class RadioRenderer extends \WebApp\DefaultTheme\RadioRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		if (!$this->component->getAnnotation('bootstrap/no-class')) {
			$this->addClass('form-check-input');
		}
	}

}

