<?php

namespace WebApp\BootstrapTheme\HorizontalForm;

class FormCheckRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component, $elementRenderer) {
		parent::__construct($theme, $component);
		$this->elementRenderer = $elementRenderer;
	}

	public function render() {
		$this->component->addLabelClass('form-check-label');
		$rc = '<div class="form-check">'.
		         $this->elementRenderer->render().
		      '</div>';
		return $rc;
	}

}
