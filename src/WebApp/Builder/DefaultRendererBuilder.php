<?php

namespace WebApp\Builder;

class DefaultRendererBuilder extends AbstractRendererBuilder {

	protected $themeClass;

	public function __construct($theme) {
		parent::__construct($theme);
		$this->themeClass = new \ReflectionClass($theme);
	}

	public function getRenderer($component) {
		$rc         = NULL;
		$themeClass = $this->themeClass;
		while (($rc == NULL) && ($themeClass !== FALSE)) {
			$namespace  = $themeClass->getNamespaceName();
			$rc         = $this->searchRendererInNamespace($namespace, $component);
			$themeClass = $themeClass->getParentClass();
		}

		if ($rc == NULL) {
			$rc = new \WebApp\Renderer($this->theme, $component);
		}
		return $rc;
	}

}
