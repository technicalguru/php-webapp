<?php

namespace WebApp\DefaultTheme;

class DivRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'div');
	}
}

