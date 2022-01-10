<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class InlineFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('form-inline');
	}

	public function render() {
		$this->theme->pushRendererBuilder(new InlineForm\InlineFormRendererBuilder($this->theme));
		$rc  = parent::render();
		$this->theme->popRendererBuilder();
		return $rc;
	}

}

