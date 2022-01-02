<?php

namespace WebApp\BootstrapTheme\InlineForm;

class FormCheckRenderer extends \WebApp\BootstrapTheme\FormCheckRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->component->setInline(TRUE);
	}

}

