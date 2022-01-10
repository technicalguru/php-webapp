<?php

namespace WebApp\BootstrapTheme;

class DateInputRenderer extends InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(BootstrapTheme::DATEPICKER);
		$this->addClass('datepicker');
		$this->component->setType('text');
		$this->component->setPrependContent('<i class="fas fa-calendar-alt"></i>');
	}
}
