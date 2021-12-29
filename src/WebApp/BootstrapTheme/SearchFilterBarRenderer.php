<?php

namespace WebApp\BootstrapTheme;

class SearchFilterBarRenderer extends InlineFormRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(BootstrapTheme::SEARCH_FILTER);
	}

}

