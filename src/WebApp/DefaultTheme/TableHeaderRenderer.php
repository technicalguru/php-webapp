<?php

namespace WebApp\DefaultTheme;

class TableHeaderRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'thead');
	}
}

