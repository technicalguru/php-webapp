<?php

namespace WebApp\DefaultTheme;

class ListItemRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'li');
	}
}

