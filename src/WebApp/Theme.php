<?php

namespace WebApp;

use TgI18n\I18N;

/** A basic theme that has no layout at all */
class Theme {

	/** Information about the app */
	public    $app              = NULL;
	/** The current page */
	protected $page             = NULL;
	/** Enabled features */
	protected $features         = NULL;
	/** Stack of RendererBuilders */
	protected $rendererBuilders = NULL;

	public function __construct($app) {
		$this->app              = $app;
		$this->features         = array();
		$app->theme             = $this;
		$this->rendererBuilders = new \TgUtils\Stack(new Builder\DefaultRendererBuilder($this));
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

	/**
	  * Rendering is delegated to Renderer objects.
	  * Any component can define a renderer by annotation "webapp/renderer" which
	  *   always takes precendence.
	  * Creation of renderers are delegated to RendererBuilder objects in order
	  *   to allow components/themes to influence rendering of some HTML children.
	  * A RendererBuilder can refuse to deliver a Renderer so the renderer "above" will
	  *   be asked to create a Renderer. This is helpful especially for forms.
	  * The stack of RendererBuilders can be managed by pushRendererBuilder() and 
	  *   popRendererBuilder() methods. However, the removal of builders lies in the
      *   responsibility of the object that adds a builder onto the stack.
	  */
	public function renderComponent($component) {
		if (is_string($component)) {
			// Strings are rendered directly
			return $component;
		} else if (is_array($component)) {
			// Arrays are recursively rendered per element
			$rc = '';
			foreach ($component AS $c) {
				$rc .= $this->renderComponent($c);
			}
			return $rc;
		} else if (is_object($component)) {
			// Objects will be rendered with according renderers
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
	public function getRenderer($component) {
		// An annotation can overwrite the renderer
		$renderer   = $this->getAnnotatedRenderer($component);
		if ($renderer == NULL) {
			// The stack will be asked from top to bottom
			foreach ($this->rendererBuilders->elements() AS $builder) {
				$renderer = $builder->getRenderer($component);
				if ($renderer != NULL) break;
			}
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

	public function pushRendererBuilder($builder) {
		$this->rendererBuilders->push($builder);
	}

	public function popRendererBuilder() {
		// Never remove the top-most builder
		if ($this->rendererBuilders->size() > 1) {
			return $this->rendererBuilders->pop();
		}
		return NULL;
	}
}

