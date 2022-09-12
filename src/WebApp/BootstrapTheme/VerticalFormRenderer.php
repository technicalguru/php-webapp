<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class VerticalFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public $form;

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
	}

	public function render() {
		$this->theme->pushRendererBuilder(new VerticalForm\VerticalFormRendererBuilder($this->theme, $this->form));
		$rc  = parent::render();
		$this->theme->popRendererBuilder();
		return $rc;
	}

}

