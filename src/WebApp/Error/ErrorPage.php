<?php

namespace WebApp\Error;

class ErrorPage extends \WebApp\Page {

	public $errorCode;
	public $errorText;
	public $throwable;

	public function __construct($app, $errorCode, $errorText, $throwable = NULL) {
		parent::__construct($app);
		$this->errorCode = $errorCode;
		$this->errorText = $errorText;
		$this->throwable = $throwable;
	}

	public function getTitle() {
		return 'error_page_title';
	}

	public function getMain() {
		header('HTTP/1.1 '.$this->errorCode.' '.$this->errorText);
		$rc = new \WebApp\Component\MainContent($this);
		$rc->addClass('text-center');
		// TODO Add this text in white on black image with broken glass
		new \WebApp\Component\Title($rc, 'error_page_title');
		new \WebApp\Component\Subtitle($rc, 'error_page_subtitle');
		$p = new \WebApp\Component\Paragraph($rc, 'error_page_description');
		$p->addClass('small');
		if (($this->throwable != NULL) && ($DEBUG || ($this->app->config->has('debug') && $this->app->config->get('debug')))) {
			$rc->addChild('<pre class="text-left">'.\TgUtils\FormatUtils::getTraceAsString($this->throwable).'</pre>');
		}
		return $rc;
	}
}

