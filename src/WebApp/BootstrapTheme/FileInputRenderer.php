<?php

namespace WebApp\BootstrapTheme;

class FileInputRenderer extends InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::FILEUPLOAD);
	}
}

