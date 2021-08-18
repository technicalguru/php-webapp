<?php

namespace WebApp\BootstrapTheme;

class FilterPanelRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(BootstrapTheme::SEARCH_FILTER);
	}

}

