<?php

namespace WebApp\DefaultTheme;

class ParagraphRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'p');
	}
}

