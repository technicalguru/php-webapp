<?php

namespace WebApp\BootstrapTheme\VerticalForm;

class InputRenderer extends \WebApp\BootstrapTheme\InputRenderer {

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
		$rc   .= $this->renderInput();
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

}
