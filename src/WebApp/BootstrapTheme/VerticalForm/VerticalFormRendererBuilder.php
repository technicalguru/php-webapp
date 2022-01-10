<?php

namespace WebApp\BootstrapTheme\VerticalForm;

class VerticalFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	protected $form;

	public function __construct($theme, $form) {
		parent::__construct($theme);
		$this->form = $form;
	}

	public function getRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme\VerticalForm', $component);
		if (($rc == NULL) && is_a($component, 'WebApp\Component\FormElement')) {
			$elemRenderer = $this->getComponentRenderer($component);
			if (is_a($component, 'WebApp\Component\FormCheck')) {
				$rc = $elemRenderer;
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
