<?php

namespace WebApp\DefaultTheme;

class TableRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'table');
	}
}

