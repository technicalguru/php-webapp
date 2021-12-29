<?php

namespace WebApp\BootstrapTheme\VerticalForm;

class TextAreaRenderer extends \WebApp\BootstrapTheme\TextAreaRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$child = $this->component;
		$error = $child->getError();
		$rc    = '<div class="form-group'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'">'.$label.'</label>';
		}
		if ($error != NULL) {
			$this->addClass('is-invalid');
			$this->addAttribute('aria-describedby', 'validationFeedback-'.$child->getId());
		}
		$rc   .= parent::render();
		$help  = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<small class="form-text text-muted">'.$help.'</small>';
		}
		$error = $child->getError();
		if ($error != NULL) {
			$rc .= '<div id="validationFeedback-'.$child->getId().'" class="invalid-feedback">'.$error.'</div>';
		}
		$rc .= '</div>';
		return $rc;
	}

}
