<?php

namespace WebApp\DefaultTheme;

class HeadingRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'h'.$component->getLevel());
	}
}

