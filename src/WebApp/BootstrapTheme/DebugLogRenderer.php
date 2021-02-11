<?php

namespace WebApp\BootstrapTheme;

class DebugLogRenderer extends \WebApp\DefaultTheme\DebugLogRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('container-fluid');
		$this->setStyle('border-top', '1px solid #999');
		$this->setStyle('margin-top', '2em');
		$this->setStyle('padding-top', '1em');
	}

}

