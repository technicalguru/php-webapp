<?php

namespace WebApp\DefaultTheme;

class SubtitleRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'p');
		$this->addClass('subtitle');
	}
}

