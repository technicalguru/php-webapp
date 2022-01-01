<?php

namespace WebApp\BootstrapTheme\HorizontalForm;

class FieldSetRenderer extends \WebApp\BootstrapTheme\FieldSetRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('horizontal-fieldset');
	}

}
