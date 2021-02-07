<?php

namespace WebApp\Error;

class Error500 extends \WebApp\Page {

	public function __construct($app, $throwable = NULL) {
		parent::__construct($app);
		$this->throwable = $throwable;
	}

	public function getTitle() {
		return 'page500_title';
	}

	public function getMain() {
		header('HTTP/1.1 500 Internal Error');
		$rc = new \WebApp\Component\MainContent($this);
		new \WebApp\Component\Title($rc, 'page500_title');
		new \WebApp\Component\Subtitle($rc, 'page500_subtitle');
		$p = new \WebApp\Component\Paragraph($rc, 'page500_description');
		$p->addClass('small');
		if (($this->throwable != NULL) && ($DEBUG || ($this->app->config->has('debug') && $this->app->config->get('debug')))) {
			$rc->addChild('<pre>'.\TgUtils\FormatUtils::getTraceAsString($this->throwable).'</pre>');
		}
		return $rc;
	}
}

