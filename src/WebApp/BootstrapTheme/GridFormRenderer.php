<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class GridFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
	}

	public function render() {
		$builder = new GridForm\GridFormRendererBuilder($this->theme, $this->component);
		$this->theme->pushRendererBuilder($builder);
		$rc  = parent::render();
		$this->theme->popRendererBuilder();
		if ($builder->hasRow()) $rc .= $builder->endRow();
		return $rc;
	}

}

