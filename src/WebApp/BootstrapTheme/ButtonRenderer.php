<?php

namespace WebApp\BootstrapTheme;

class ButtonRenderer extends \WebApp\DefaultTheme\ButtonRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('btn');
		if ($component->getType() == 'submit') $this->addClass('btn-primary');
	}
}

