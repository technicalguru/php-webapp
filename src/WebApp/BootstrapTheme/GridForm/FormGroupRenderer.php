<?php

namespace WebApp\BootstrapTheme\GridForm;

class FormGroupRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component, $builder, $elementRenderer) {
		parent::__construct($theme, $component);
		$this->builder         = $builder;
		$this->elementRenderer = $elementRenderer;
		$this->componentSizes  = 'col-'.implode(' col-', explode(' ', $component->getAnnotation('grid-form/component-size', 'sm-12 md-8 lg-10')));
	}

	public function startRow() {
		$rc = '';
		if ($this->component->getAnnotation('grid-form/new-row', FALSE) || !$this->builder->hasRow()) {
			if ($this->builder->hasRow()) {
				$rc .= '</div>';
				$rc = $this->builder->endRow();
			}
			$rc .= $this->builder->startRow();
		}
		return $rc;
	}

	public function render() {
		// Ensure a row
		$rc     = $this->startRow();

		$child  = $this->component;
		$error  = $child->getError();
		$rc    .= '<div class="form-group '.$this->getComponentSizeClasses().($error != NULL ? ' has-error' : '').'" id="form-group-'.$child->getId().'">';
		$rc    .= $this->renderLabel();
		if ($error != NULL) {
			$this->addClass('is-invalid');
			$this->addAttribute('aria-describedby', 'validationFeedback-'.$child->getId());
		}

		// we need to push defaultBuilder again
		$this->theme->pushRendererBuilder(new \WebApp\Builder\DefaultRendererBuilder($this->theme));
		$rc   .= $this->elementRenderer->render();

		$help  = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<small class="form-text text-muted">'.$help.'</small>';
		}
		$error = $child->getError(); // Could have been rendered already
		if ($error != NULL) {
			$rc .= '<div id="validationFeedback-'.$child->getId().'" class="invalid-feedback">'.$error.'</div>';
		}

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
			//$style    = is_a($this->component, 'WebApp\Component\DynamicField') ? ' style="margin-top: 0.5em;"' : '';
			$rc .= '<label for="'.htmlentities($this->component->getId()).'">'.$label.$required.'</label>';
		}
		return $rc;
	}

	public function getComponentSizeClasses() {
		return $this->componentSizes;
	}

}
