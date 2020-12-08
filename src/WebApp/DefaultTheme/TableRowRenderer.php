<?php

namespace WebApp\DefaultTheme;

class TableRowRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'tr');
	}
}

