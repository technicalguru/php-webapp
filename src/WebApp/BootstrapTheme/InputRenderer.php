<?php

namespace WebApp\BootstrapTheme;

class InputRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
		if ($component->getError() != NULL) $this->addClass('is-invalid');
	}

}

