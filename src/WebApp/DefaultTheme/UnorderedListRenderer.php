<?php

namespace WebApp\DefaultTheme;

class UnorderedListRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'ul');
	}
}

