<?php

namespace WebApp\BootstrapTheme;

use \TgI18n\I18N;

class SelectRenderer extends \WebApp\DefaultTheme\SelectRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
	}

}

