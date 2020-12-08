<?php

namespace WebApp\BootstrapTheme;

class TableRenderer extends \WebApp\DefaultTheme\TableRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('table');
	}
}

