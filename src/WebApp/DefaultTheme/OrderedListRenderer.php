<?php

namespace WebApp\DefaultTheme;

class OrderedListRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'ol');
	}
}

