<?php

namespace WebApp\DefaultTheme;

class FormRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
	}

	public function render() {
		$renderer = $this->getFormRenderer();
		if ($renderer != NULL) {
			return $renderer->render();
		}
		return parent::render();
	}

	public function getFormRenderer() {
		$themeClass    = new \ReflectionClass($this->theme);
		$namespaceName = $themeClass->getNamespaceName();
		$rendererClass = $namespaceName.'\\'.ucfirst($this->component->getType()).'FormRenderer';
		if (class_exists($rendererClass)) {
			$rendererClass = '\\'.$rendererClass;
			return new $rendererClass($this->theme, $this->component);
		}
		return NULL;
	}

	public function renderFormChildren($children) {
		$renderer = $this->getFormRenderer();
		if ($renderer != NULL) {
			return $renderer->renderFormChildren($children);
		}
		return '';
	}
}

