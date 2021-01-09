<?php

namespace WebApp\BootstrapTheme;

class TextAreaRenderer extends \WebApp\DefaultTheme\TextAreaRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
		if ($component->getError() != NULL) $this->addClass('is-invalid');
	}

}

