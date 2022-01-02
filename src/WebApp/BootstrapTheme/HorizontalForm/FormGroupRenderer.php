<?php

namespace WebApp\BootstrapTheme\HorizontalForm;

class FormGroupRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component, $elementRenderer) {
		parent::__construct($theme, $component);
		$this->elementRenderer = $elementRenderer;
	}

	public function render() {
		$child = $this->component;
		$error = $child->getError();
		$rc    = '<div class="form-group row'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
		$rc   .= $this->renderLabel();
		if ($error != NULL) {
			$this->addClass('is-invalid');
			$this->addAttribute('aria-describedby', 'validationFeedback-'.$child->getId());
		}

		// Do we need to push defaultBuilder again?
		$this->theme->pushRendererBuilder(new \WebApp\Builder\DefaultRendererBuilder($this->theme));
		$rc   .= '<div class="col-sm-10">'.
		            $this->elementRenderer->render();

		$help  = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<small class="form-text text-muted">'.$help.'</small>';
		}
		$error = $child->getError(); // Could have been rendered already
		if ($error != NULL) {
			$rc .= '<div id="validationFeedback-'.$child->getId().'" class="invalid-feedback">'.$error.'</div>';
		}

		$rc .= '</div>';
		// Undo defaultBuilder again
		$this->theme->popRendererBuilder();

		$rc .= '</div>';
		return $rc;
	}

	protected function renderLabel() {
		$rc = '';
		$label = $this->component->getLabel();
		if ($label != NULL) {
			$required = $this->component->isRequired() ? '<sup class="text-danger">*</sup>' : '';
			$style    = is_a($this->component, 'WebApp\Component\DynamicField') ? ' style="margin-top: 0.5em;"' : '';
			$rc .= '<label class="col-sm-2 col-form-label" for="'.htmlentities($this->component->getId()).'"'.$style.'>'.$label.$required.'</label>';
		}
		return $rc;
	}
}
