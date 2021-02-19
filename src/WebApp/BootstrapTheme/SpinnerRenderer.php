<?php

namespace WebApp\BootstrapTheme;

class SpinnerRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('spinner-border');
		$this->addClass('text-'.$this->component->getType());
		$this->addClass('ml-1');

		$text = new \WebApp\Component\Text($this->component, $this->component->getText());
		$text->addClass('sr-only');
	}

}

