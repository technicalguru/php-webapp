<?php

namespace WebApp\BootstrapTheme\InlineForm;

class ButtonRenderer extends \WebApp\BootstrapTheme\ButtonRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('mb-2');
	}
}

