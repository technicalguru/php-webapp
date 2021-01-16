<?php

namespace WebApp\BootstrapTheme;

class DateInputRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(BootstrapTheme::DATEPICKER);
		$this->addClass('datepicker');
		$this->component->setType('text');
	}

	public function render() {
		$rc  = '<div class="input-group date">'.
		          '<div class="input-group-prepend input-group-addon">'.
		             '<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>'.
		          '</div>'.
		          $this->renderStartTag('input').
		       '</div>';
		return $rc;
	}
}
