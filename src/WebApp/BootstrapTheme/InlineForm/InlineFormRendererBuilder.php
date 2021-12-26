<?php

namespace WebApp\BootstrapTheme\InlineForm;

class InlineFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	public function __construct($theme) {
		parent::__construct($theme);
	}

	public function getRenderer($component) {
		if (is_a($component, '\WebApp\Component\Button')) {
			return new ButtonRenderer($this->theme, $component);
		}
		if (is_a($component, '\WebApp\Component\DateRangeInput')) {
			return new DateRangeInputRenderer($this->theme, $component);
		}
		if (is_a($component, '\WebApp\Component\Input')) {
			return new InputRenderer($this->theme, $component);
		}
		return NULL;
	}
}
