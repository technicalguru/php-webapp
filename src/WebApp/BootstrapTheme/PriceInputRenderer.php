<?php

namespace WebApp\BootstrapTheme;

class PriceInputRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
	}

	public function render() {
		$currency = $this->component->getCurrency();
		$rc  = '<div class="input-group">';
		if ($currency != NULL) {
			$rc .= '<div class="input-group-prepend"><span class="input-group-text">'.$currency.'</span></div>';
		}
		$rc .= parent::render().
		       '</div>';
		return $rc;
	}
}
