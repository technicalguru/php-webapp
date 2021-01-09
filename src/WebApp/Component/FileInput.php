<?php

namespace WebApp\Component;

class FileInput extends Input {

	public function __construct($parent, $id) {
		parent::__construct($parent, $id, 'file');
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::FILEUPLOAD);
	}

}

