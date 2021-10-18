<?php

namespace WebApp;

use TgI18n\I18N;

/** A basic theme that has no layout at all */
class Theme {

	/** Information about the app */
	public    $app      = NULL;
	protected $page     = NULL;
	protected $class    = NULL;
	protected $features = NULL;
	protected $useCache = FALSE;

	public function __construct($app, $useCache = TRUE) {
		$this->app       = $app;
		$this->class     = new \ReflectionClass($this);
		$this->features  = array();
		$app->theme      = $this;
		$this->useCache  = $useCache;
		if ($this->useCache) {
			$this->initCache();
		}
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

		// Ask the layout factory
		$layout = $this->app->getLayoutFactory()->getLayout($this, $page);

		// Fallback to this object
		if ($layout == NULL) {
			$layout = $this;
		}

		$html = $layout->renderPage();

		if ($this->useCache) {
			$this->saveCache();
		}
		echo $html;
	}

	/**
     * Themes shall override this function and return a layout object
     * depending on the current page object.
	 * @return name of layout (this method returns 'default')
	 */
	public function getLayoutName() {
		return 'default';
	}

	/**
     * A very basic rendering page.
     * @param object $page - the page to be rendered.
     * @return HTML of the complete page
     */
	protected function renderPage() {
		$rc .= '<html lang="'.$this->app->request->language.'>'.
		         '<head>'.
		           '<title>'.I18N::_($this->page->getTitle()).' - '.I18N::_($this->app->getName()).'</title>'.
		         '</head>'.
		         '<body lang="'.$this->app->request->language.'>'.
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
			if (is_a($component, 'WebApp\\Component\\LazyInitializer')) {
				$component->lazyInit();
			}
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
		// An annotation can overwrite the renderer
		$renderer   = $this->getAnnotatedRenderer($component);
		if ($renderer == NULL) {
			$renderer = $this->findCachedRenderer($component);
		}
		return $renderer;
	}

	protected function getAnnotatedRenderer($component) {
		$rc = $component->getAnnotation('webapp/renderer');
		if (($rc != NULL) && is_string($rc)) {
			$rc = new $rc($this, $component);
		}
		return $rc;
	}

	protected function findCachedRenderer($component) {
		$renderer = NULL;
		if ($this->useCache) {
			$className = $this->getRendererCache(get_class($component));
			if ($className != NULL) {
				$renderer = new $className($this, $component);
			}
		}

		if ($renderer == NULL) {
			$themeClass = $this->class;
			while (($renderer == NULL) && ($themeClass !== FALSE)) {
				$namespace  = $themeClass->getNamespaceName();
				$renderer   = $this->searchRendererInNamespace($namespace, $component);
				$themeClass = $themeClass->getParentClass();
			}

			if ($renderer == NULL) {
				$renderer = new Renderer($this, $component);
			}
			if ($this->useCache) {
				$this->setRendererCache(get_class($component), get_class($renderer));
			}
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

	/** Adds a feature for the theme, e.g. for CSS or JS. Interpretation up to implementations. */
	public function addFeature($name) {
		if (!in_array($name, $this->features)) $this->features[] = $name;
	}

	public function removeFeature($name) {
		$newArr = array();
		foreach ($this->features AS $f) {
			if ($f != $name) $newArr[] = $f;
		}
		$this->features = $newArr;
	}

	/** Returns enabled theme features, e.g. for CSS or JS. Interpretation up to implementations. */
	public function getFeatures() {
		return $this->features;
	}

	public function hasFeature($name) {
		return in_array($name, $this->features);
	}

	public function getErrorPage($htmlCode, $text, $throwable = NULL) {
		$rc = $this->app->getErrorPage($htmlCode, $text, $throwable);
		if ($rc == NULL) $rc = new \WebApp\Error\ErrorPage($this->app, $htmlCode, $text, $throwable);
		return $rc;
	}

	// Renderer Cache
	protected function initCache() {
		$this->rendererCache = array();
		// Loading from disk => concurrency!
	}

	protected function saveCache() {
		// Saving to disk => concurrency!
	}

	protected function getRendererCache($name) {
		if (isset($this->rendererCache[$name])) return $this->rendererCache[$name];
		return NULL;
	}

	protected function setRendererCache($name, $value) {
		$this->rendererCache[$name] = $value;
	}

}

