<?php

namespace WebApp\BootstrapTheme;

class FormCheckRenderer extends \WebApp\DefaultTheme\FormCheckRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		if (!$this->component->getAnnotation('bootstrap/no-class')) {
			$this->component->addClass('form-check-input');
		}
		$this->component->addLabelClass('form-check-label');
	}

	public function render() {
		$inline = $this->component->isInline() ? ' form-check-inline' : '';
		$rc = '<div class="form-check'.$inline.'">'.
		         parent::render().
		      '</div>';
		return $rc;
	}
}

