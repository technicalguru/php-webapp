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
		$rc = '<meta charset="utf-8">'.
		      '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'.
		      '<meta name="pageclass" content="'.get_class($this->page).'">';
		// keywords
		$keywords = $this->page->getMetaKeywords();
		if ($keywords != NULL) {
			if (is_array($keywords)) $keywords = implode(',', $keywords);
			$rc .= '<meta name="keywords" content="'.htmlentities($keywords).'">';
		}
		// descriptions
		$description = $this->page->getMetaDescription();
		if ($description != NULL) {
			$rc .= '<meta name="description" content="'.htmlentities($description).'">';
		}
		// canonical
		$params = $this->app->request->params ? '?'.$this->app->request->params : '';
		$rc .= '<meta name="canonical" content="'.htmlentities($this->app->router->getCanonicalPath().$params).'">';
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
			//	$rc .= '<link rel="stylesheet" href="'.Utils::getCssBaseUrl().'/'.$file.'" rel="stylesheet" type="text/css">';
			//} else {
				$rc .= '<link rel="stylesheet" href="'.$file.'" rel="stylesheet" type="text/css">';
			//}
		}
		return $rc;
	}

	protected function renderTitle() {
		return '<title>'.I18N::_($this->page->getTitle()).' - '.I18N::_($this->app->getName()).'</title>';
	}

	protected function renderBody() {
		$rc = '<body>'.
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


