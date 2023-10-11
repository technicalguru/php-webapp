<?php

namespace WebApp\BootstrapTheme\HorizontalForm;

class HorizontalFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	protected $form;
	protected $labelSizes;
	protected $componentSizes;

	public function __construct($theme, $form) {
		parent::__construct($theme);
		$this->form           = $form;
		$this->labelSizes     = 'col-'.implode(' col-', explode(' ', $this->form->getAnnotation('horizontal-form/label-size',     'sm-12 md-4 lg-2')));
		$this->componentSizes = 'col-'.implode(' col-', explode(' ', $this->form->getAnnotation('horizontal-form/component-size', 'sm-12 md-8 lg-10')));
	}

	public function getRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme\HorizontalForm', $component);
		if (($rc == NULL) && is_a($component, 'WebApp\Component\FormElement')) {
			$elemRenderer = $this->getComponentRenderer($component);
			if (is_a($component, 'WebApp\Component\FormCheck')) {
				$rc = $elemRenderer;
			} else {
				$rc = new FormGroupRenderer($this->theme, $component, $this, $elemRenderer);
			}
		}
		return $rc;
	}

	protected function getComponentRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme', $component);
		if ($rc == NULL) {
			$rc = $this->searchRendererInNamespace('WebApp\DefaultTheme', $component);
		}
		if ($rc == NULL) {
			$rc = new \WebApp\Renderer($this->theme, $component);
		}
		return $rc;
	}

	public function getLabelSizeClasses() {
		return $this->labelSizes;
	}

	public function getComponentSizeClasses() {
		return $this->componentSizes;
	}

}
