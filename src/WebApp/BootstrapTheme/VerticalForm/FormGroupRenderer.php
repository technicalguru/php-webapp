<?php

namespace WebApp\BootstrapTheme\VerticalForm;

class FormGroupRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component, $elementRenderer) {
		parent::__construct($theme, $component);
		$this->elementRenderer = $elementRenderer;
	}

	public function render() {
		$child = $this->component;
		$error = $child->getError();
		$rc    = '<div class="form-group'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$required = $this->component->isRequired() ? '<sup class="text-danger">*</sup>' : '';
			$rc .= '<label for="'.htmlentities($child->getId()).'">'.$label.$required.'</label>';
		}
		if ($error != NULL) {
			$this->addClass('is-invalid');
			$this->addAttribute('aria-describedby', 'validationFeedback-'.$child->getId());
		}
		$rc   .= $this->elementRenderer->render();
		$help  = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<small class="form-text text-muted">'.$help.'</small>';
		}
		$error = $child->getError(); // Could have been rendered already
		if ($error != NULL) {
			$rc .= '<div id="validationFeedback-'.$child->getId().'" class="invalid-feedback">'.$error.'</div>';
		}
		$rc .= '</div>';
		return $rc;
	}

/*
	public function renderInput() {
		$rc      = '';
		$prepend = $this->component->getPrependContent();
		$append  = $this->component->getAppendContent();
		$isGroup = ($prepend != NULL) || ($append != NULL);

		if ($isGroup) {
			$rc  = '<div class="input-group mb-2 mr-sm-2">';
			if ($prepend != NULL) {
				$rc .= '<div class="input-group-prepend">'.
						 '<span class="input-group-text">'.$prepend.'</span>'.
					   '</div>';
			}
			$rc .= $this->renderStartTag('input');
			if ($append != NULL) {
				$rc .= '<div class="input-group-append">'.
						 '<span class="input-group-text">'.$append.'</span>'.
					   '</div>';
			}
			$rc .= '</div>';
		} else {
			$this->addClass('mb-2', 'mr-sm-2');
			$rc .= $this->renderStartTag('input');
		}

		return $rc;
	}
*/
}
