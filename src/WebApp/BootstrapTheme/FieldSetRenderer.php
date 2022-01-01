<?php

namespace WebApp\BootstrapTheme;

class FieldSetRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('fieldset');
	}

	public function render() {
		$heading = new \WebApp\Component\Heading($this->component, 3, $this->component->getLabel());
		$this->component->moveChildTo($heading, 0);
		return parent::render();
	}
}
