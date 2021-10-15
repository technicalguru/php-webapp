<?php

namespace WebApp;

class LayoutFactory {

	protected $app;
	protected $layouts;

	public function __construct($app) {
		$this->app     = $app;
		$this->layouts = array();
	}

	public function getLayout($theme, $page) {
		$name = $page->getLayoutName();
		if ($name == NULL) {
			$name = $theme->getLayoutName();
		}
		if ($name == NULL) {
			$name = 'default';
		}

		if (!isset($this->layouts[$name])) {
			$this->layouts[$name] = $this->createLayout($name, $theme, $page);
		}
		return $this->layouts[$name];
	}

	/** Descendants shall override this method and fallback on parent implementation */
	protected function createLayout($name, $theme, $page) {
		$class     = new \ReflectionClass($theme);
		$className = strpos($name, '\\') === FALSE ? $class->getNamespaceName().'\\'.ucfirst($name).'Layout' : $name;
		if (class_exists($className)) {
			$className = '\\'.$className;
			return new $className($theme, $page);
		}
		$className = $class->getNamespaceName().'\\DefaultLayout';
		if (class_exists($className)) {
			$className = '\\'.$className;
			return new $className($theme, $page);
		}
		return NULL;
	}
}

