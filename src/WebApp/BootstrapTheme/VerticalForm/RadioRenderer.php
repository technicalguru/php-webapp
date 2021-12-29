<?php

namespace WebApp\BootstrapTheme\InlineForm;

class RadioRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'radio');
	}

	public function render() {
		$rc = '<div class="form-check">'.
		         $this->renderStartTag('input').
		         '<label class="form-check-label" for="'.htmlentities($this->component->getId()).'">'.$this->component->getLabel().'</label>'.
		      '</div>';
		return $rc;
	}

}

