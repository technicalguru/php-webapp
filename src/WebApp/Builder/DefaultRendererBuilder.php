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

	protected function searchRendererInNamespace($namespace, $component) {
		$class = new \ReflectionClass($component);
		$rc    = NULL;

		while (($rc == NULL) && ($class !== FALSE)) {
			$shortName = $class->getShortName();
			$className = '\\'.$namespace.'\\'.$shortName.'Renderer';
			if (class_exists($className)) {
				$rc = new $className($this->theme, $component);
			} else {
				$class = $class->getParentClass();
			}
		}

		return $rc;
	}

}
