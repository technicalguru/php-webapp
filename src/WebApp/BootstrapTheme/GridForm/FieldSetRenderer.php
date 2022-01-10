<?php

namespace WebApp\BootstrapTheme\GridForm;

class FieldSetRenderer extends \WebApp\BootstrapTheme\FieldSetRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('grid-fieldset');
	}

}
