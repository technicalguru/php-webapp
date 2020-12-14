<?php

namespace WebApp\BootstrapTheme;

class SubtitleRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'p');
		$this->addClass('lead');
	}
}

