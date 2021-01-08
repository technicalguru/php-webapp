<?php

namespace WebApp\Component;

class DateInput extends Input {

	public function __construct($parent, $id, $value = null) {
		parent::__construct($parent, $id, 'date', $value);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::DATEPICKER);
	}

}

