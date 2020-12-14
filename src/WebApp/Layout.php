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
		$rc = $this->renderDocumentBegin().
		      $this->renderHeader().
		      $this->renderBody().
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
		return '<meta charset="utf-8">'.
		       '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">'.
		       '<meta name="pageclass" content="'.get_class($this->page).'">';
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

	protected function renderLog() {
		$rc = array();
		if ($this->app->config->has('debug') && $this->app->config->get('debug')) {
			$rc[] = new Component\Heading($this->page, 4, 'Debug Log');

			$log = '';
			foreach (Log::instance()->messages AS $sev => $msgs) {
				foreach ($msgs AS $msg) {
					$log .= '['.strtoupper($sev).'] '.htmlspecialchars($msg)."\n";
				}
			}
			$rc[] = new Component\Preformatted($this->page, $log);
		}
		return $rc;
	}

	protected function renderJavascript() {
		$js = array_merge($this->app->getJavascript(),  $this->page->getJavascript());
		return implode($js);
	}
}


