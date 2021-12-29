<?php

namespace WebApp\BootstrapTheme\VerticalForm;

class CheckboxRenderer extends \WebApp\BootstrapTheme\CheckboxRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc = '<div class="form-check">'.
		         $this->renderStartTag('input').
		         '<label class="form-check-label" for="'.htmlentities($this->component->getId()).'">'.$this->component->getLabel().'</label>'.
		      '</div>';
		return $rc;
	}

}

