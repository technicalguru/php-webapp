<?php

namespace WebApp;

use \TgLog\Log;
use \TgI18n\I18N;

class Layout {

	protected $theme;
	protected $app;
	protected $page;

	public function __construct($theme, $page) {
		$this->theme = $theme;
		$this->page  = $page;
		$this->app   = $theme->app;
	}

	public function renderPage() {
		// Render body before header so CSS registrations can happen
		$body = $this->renderBody();
		$rc = $this->renderDocumentBegin().
		      $this->renderHeader().
		      $body.
		      $this->renderDocumentEnd();
		return $rc;
	}

	protected function renderDocumentBegin() {
		return '<!doctype html><html lang="'.I18N::$defaultLangCode.'">';
	}

	protected function renderDocumentEnd() {
		return '</html>';
	}

	protected function renderHeader() {
		$rc = '<head>'.
		      $this->renderMeta().
		      $this->renderLinks().
		      $this->renderTitle().
		      '</head>';
		return $rc;
	}

	protected function renderMeta() {
		$rc = '<meta charset="utf-8">';

		// Meta
		$meta = $this->page->getMeta();

		// Some specifics
		if (!isset($meta['viewport']))  $meta['viewport']  = 'width=device-width, initial-scale=1, shrink-to-fit=no';
		if (!isset($meta['pageclass'])) $meta['pageclass'] = get_class($this->page);
		if (!isset($meta['canonical'])) {
			$params = $this->app->request->params ? '?'.$this->app->request->params : '';
			$meta['canonical'] = $this->app->router->getCanonicalPath().$params;
		}

		foreach ($meta AS $name => $content) {
			$s   = is_array($content) ? implode(',', $content) : $content;
			$rc .= '<meta name="'.$name.'" content="'.htmlentities($s).'">';
		}

		// Alternates
		foreach ($this->app->router->getLanguages() AS $key => $label) {
			if ($key != $this->app->request->language) {
				$rc .= '<meta name="alternate" hreflang="'.$key.'" content="'.htmlentities($this->app->router->getCanonicalPath(NULL, $key).$params).'">';
			}
		}

		return $rc;
	}

	/** Attention! When overriding call parent at last in your method as the app links will be rendered here */
	protected function renderLinks() {
		$rc = '';
		$files = $this->app->getCssFiles();
		if (!is_array($files)) $files = array($files);
		foreach ($files AS $file) {
			//if (strpos($file, '://') === FALSE) {
			//	$rc .= '<link rel="stylesheet" href="'.Utils::getCssBaseUrl().'/'.$file.'" type="text/css">';
			//} else {
				$rc .= '<link rel="stylesheet" href="'.$file.'" type="text/css">';
			//}
		}
		return $rc;
	}

	protected function renderTitle() {
		return '<title>'.I18N::_($this->page->getTitle()).' - '.I18N::_($this->app->getName()).'</title>';
	}

	protected function renderBody() {
		$rc = '<body lang="'.$this->app->request->language.'>'.
		      $this->theme->renderComponent($this->page->getMain()).
		      $this->theme->renderComponent($this->renderLog()).
		      $this->renderJavascript().
		      '</body>';
		return $rc;
	}

	public function renderLog() {
		if ($this->app->config->has('debug') && $this->app->config->get('debug')) {
			return new Component\DebugLog($this->page);
		}
		return array();
	}

	protected function renderJavascript() {
		$js = array_merge($this->app->getJavascript(),  $this->page->getJavascript());
		return implode($js);
	}
}


