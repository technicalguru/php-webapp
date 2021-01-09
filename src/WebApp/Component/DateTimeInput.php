<?php

namespace WebApp\Component;

class DateTimeInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'datetime', $value);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::DATEPICKER);
	}

}


