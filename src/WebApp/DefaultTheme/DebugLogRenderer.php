<?php

namespace WebApp\DefaultTheme;

class DebugLogRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'div');
	}

}

