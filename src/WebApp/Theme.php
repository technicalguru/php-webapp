<?php

namespace WebApp;

use TgI18n\I18N;

/** A basic theme that has no layout at all */
class Theme {

	/** Information about the app */
	public    $app   = NULL;
	protected $page  = NULL;
	protected $class = NULL;

	public function __construct($app) {
		$this->app       = $app;
		$this->class     = new \ReflectionClass($this);
	}

	/** The entry function for the theme. Renders the complete page in this theme.
     * The page will deliver the layout name and the call will be forwarded to
     * the layout. If no layout can be found or is defined, this theme will
     * stand in for the missing layout.
     * @param object $page - page object to be rendered
     * @return nothing
     */
	public function render($page) {
		$this->page = $page;

		// Get the layout of the page
		$layoutName = $page->getLayoutName();

		// Fallback to default theme layout
		if ($layoutName == NULL) {
			$layoutName = $this->getLayoutName();
		}

		// get the layout
		$layout = $this->getLayout($layoutName);

		// Fallback to this object
		if ($layout == NULL) {
			$layout = $this;
		}

		$html = $layout->renderPage();
		echo $html;
	}

	/**
     * Themes shall override this function and return a layout object
     * depending on the current page object.
	 * @return name of layout (this method returns 'default')
	 */
	protected function getLayoutName() {
		return 'default';
	}

	/** 
     * Return a layout object for the given name. 
     * @return the layout object (can be NULL)
     */
	protected function getLayout($name) {
		if ($name == NULL) $name = 'default';
		$className = $this->class->getNamespaceName().'\\'.ucfirst($name).'Layout';
		if (class_exists($className)) {
			$className = '\\'.$className;
			return new $className($this, $this->page);
		}
		$className = $this->class->getNamespaceName().'\\DefaultLayout';
		if (class_exists($className)) {
			$className = '\\'.$className;
			return new $className($this, $this->page);
		}
		return NULL;
	}

	/**
     * A very basic rendering page.
     * @param object $page - the page to be rendered.
     * @return HTML of the complete page
     */
	protected function renderPage() {
		$rc .= '<html>'.
		         '<head>'.
		           '<title>'.I18N::_($this->page->getTitle()).' - '.I18N::_($this->app->getName()).'</title>'.
		         '</head>'.
		         '<body>'.
		           '<h1>'.I18N::_($this->page->getTitle()).'</h1>'.
		           '<div>'.$this->renderComponent($this->page->getMain()).'</div>'.
		         '</body>'.
		       '</html>';
		return $rc;
	}

	// was: renderComponent($parentRenderer, $component)
	public function renderComponent($component) {
		if (is_string($component)) {
			return $component;
		} else if (is_array($component)) {
			$rc = '';
			foreach ($component AS $c) {
				$rc .= $this->renderComponent($c);
			}
			return $rc;
		} else if (is_object($component)) {
			return $this->getRenderer($component)->render();
		}
		return '';
	}

	/**
	 * Returns the correct renderer for the given component.
	 * <p>The return value MUST NOT be NULL.</p>
	 */
	// was getRenderer($parentRenderer, $component)
	public function getRenderer($component) {
		$renderer   = NULL;
		$themeClass = $this->class;
		while (($renderer == NULL) && ($themeClass !== FALSE)) {
			$namespace  = $themeClass->getNamespaceName();
			$renderer   = $this->searchRendererInNamespace($namespace, $component);
			$themeClass = $themeClass->getParentClass();
		}

		if ($renderer == NULL) {
			$renderer = new Renderer($this, $component);
		}
		return $renderer;
	}

	protected function searchRendererInNamespace($namespace, $component) {
		$class = new \ReflectionClass($component);
		$rc    = NULL;

		while (($rc == NULL) && ($class !== FALSE)) {
			$shortName = $class->getShortName();
			$className = '\\'.$namespace.'\\'.$shortName.'Renderer';
			if (class_exists($className)) {
				$rc = new $className($this, $component);
			} else {
				$class = $class->getParentClass();
			}
		}

		return $rc;
	}

	public function getErrorPage($htmlCode) {
		$name = '\\WebApp\\Error\\Error'.$htmlCode;
		return new $name($this->app);
	}
}

