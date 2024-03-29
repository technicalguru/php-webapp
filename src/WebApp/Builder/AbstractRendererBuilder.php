<?php

namespace WebApp\Builder;

abstract class AbstractRendererBuilder implements RendererBuilder {

	protected $theme;

	public function __construct($theme) {
		$this->theme = $theme;
	}

	public function getRenderer($component) {
		return NULL;
	}

	protected function searchRendererInNamespace($namespace, $component) {
		$class = new \ReflectionClass($component);
		$rc    = NULL;

		while (($rc == NULL) && ($class !== FALSE)) {
			$shortName = $class->getShortName();
			$className = '\\'.$namespace.'\\'.$shortName.'Renderer';
			if (class_exists($className)) {
				$rc = $this->createRenderer($className, $component);
			} else {
				$class = $class->getParentClass();
			}
		}

		return $rc;
	}

	protected function createRenderer($className, $component) {
		return new $className($this->theme, $component);
	}
}
