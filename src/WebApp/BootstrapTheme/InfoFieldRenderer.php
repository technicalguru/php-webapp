<?php

namespace WebApp\BootstrapTheme;

class InfoFieldRenderer extends InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->removeClass('form-control');
		$this->addClass('form-control-plaintext');
	}

}

