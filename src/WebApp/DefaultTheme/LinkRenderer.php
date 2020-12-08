<?php

namespace WebApp\DefaultTheme;

class LinkRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'a');
	}
}

