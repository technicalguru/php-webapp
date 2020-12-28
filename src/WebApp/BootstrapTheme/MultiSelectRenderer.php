<?php

namespace WebApp\BootstrapTheme;

use \TgI18n\I18N;

class MultiSelectRenderer extends \WebApp\DefaultTheme\MultiSelectRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
	}

}

