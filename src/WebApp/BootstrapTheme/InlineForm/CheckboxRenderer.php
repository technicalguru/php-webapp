<?php

namespace WebApp\BootstrapTheme\InlineForm;

class CheckboxRenderer extends \WebApp\BootstrapTheme\CheckboxRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc = '<div class="form-check form-check-inline">'.
		         $this->renderStartTag('input').
		         '<label class="form-check-label" for="'.htmlentities($this->component->getId()).'">'.$this->component->getLabel().'</label>'.
		      '</div>';
		return $rc;
	}

}

