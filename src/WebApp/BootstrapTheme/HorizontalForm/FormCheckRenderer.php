<?php

namespace WebApp\BootstrapTheme\HorizontalForm;

class FormCheckRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component, $elementRenderer) {
		parent::__construct($theme, $component);
		$this->elementRenderer = $elementRenderer;
	}

	public function render() {
		$rc = '<div class="form-check">'.
		         $this->elementRenderer->render().
		         '<label class="form-check-label" for="'.htmlentities($this->component->getId()).'">'.$this->component->getLabel().'</label>'.
		      '</div>';
		return $rc;
	}

}
