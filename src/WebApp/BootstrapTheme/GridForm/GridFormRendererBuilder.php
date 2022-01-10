<?php

namespace WebApp\BootstrapTheme\GridForm;

class GridFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	protected $form;

	public function __construct($theme, $form) {
		parent::__construct($theme);
		$this->form           = $form;
		$this->rowActive      = FALSE;
	}

	public function hasRow() {
		return $this->rowActive;
	}

	public function startRow() {
		$this->rowActive = TRUE;
		return  '<div class="form-row">';
	}

	public function endRow() {
		$this->rowActive = FALSE;
		return '</div>';
	}

	public function getRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme\GridForm', $component);
		if (($rc == NULL) && is_a($component, 'WebApp\Component\FormElement')) {
			$elemRenderer = $this->getComponentRenderer($component);
			if (is_a($component, 'WebApp\Component\FormCheck')) {
				$rc = $elemRenderer;
			} else {
				$rc = new FormGroupRenderer($this->theme, $component, $this, $elemRenderer);
			}
		} else if ($component->getAnnotation('grid-form/new-row', FALSE)) {
			if ($rc == NULL) $rc = $this->getComponentRenderer($component);
			$rc = new RowWrapper($this->theme, $component, $this, $rc);
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
