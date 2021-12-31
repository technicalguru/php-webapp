<?php

namespace WebApp\BootstrapTheme;

class EnableByCheckGroupRenderer extends CombinedFormElementRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::DYNAMICCHECKENABLE);
	}

}

