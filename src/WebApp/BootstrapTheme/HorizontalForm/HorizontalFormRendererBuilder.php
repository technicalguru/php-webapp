<?php

namespace WebApp\BootstrapTheme\HorizontalForm;

class HorizontalFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	protected $form;

	public function __construct($theme, $form) {
		parent::__construct($theme);
		$this->form = $form;
	}

	public function getRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme\HorizontalForm', $component);
		if (($rc == NULL) && is_a($component, 'WebApp\Component\FormElement')) {
			$elemRenderer = $this->getComponentRenderer($component);
			if (is_a($component, 'WebApp\Component\Checkbox') || is_a($component, 'WebApp\Component\Radio')) {
				$rc = new FormCheckRenderer($this->theme, $component, $elemRenderer);
			} else {
				$rc = new FormGroupRenderer($this->theme, $component, $elemRenderer);
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
}
