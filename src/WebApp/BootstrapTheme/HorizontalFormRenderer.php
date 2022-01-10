<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class HorizontalFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('horizontal');
	}

	public function render() {
		$this->theme->pushRendererBuilder(new HorizontalForm\HorizontalFormRendererBuilder($this->theme, $this->component));
		$rc  = parent::render();
		$this->theme->popRendererBuilder();
		return $rc;
	}

}

