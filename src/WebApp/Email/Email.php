<?php

namespace WebApp\Email;

/** Adds template processing methods */
class Email extends \TgEmail\Email {

	protected   $app;
	protected   $request;
	protected   $language;
	protected   $templateProcessor;

	public function __construct($app) {
		parent::__construct();
		$this->app     = $app;
		$this->request = $app->request;
	}

	protected function processHtmlTemplate() {
		return $this->processTemplate($this->getHtmlTemplate($this->getLanguage()), \TgEmail\Email::HTML);
	}

	protected function getHtmlTemplate($language) {
		return '';
	}

	protected function processTextTemplate() {
		return $this->processTemplate($this->getTextTemplate($this->getLanguage()), \TgEmail\Email::TEXT);
	}

	protected function getTextTemplate($language) {
		return '';
	}

	protected function processTemplate($template, $style) {
		$processor = $this->getTemplateProcessor();
		$processor->setStyle($style);
		return $processor->process($template);
	}

	protected function getTemplateProcessor() {
		if ($this->templateProcessor == NULL) {
			$this->templateProcessor = $this->createTemplateProcessor();
		}
		return $this->templateProcessor;
	}

	protected function createTemplateProcessor() {
		$objects    = $this->getTemplatingObjects();
		$snippets   = $this->getTemplatingSnippets();
		$formatters = $this->getTemplatingFormatters();
		$language   = $this->getLanguage();
		return new EmailTemplateProcessor($objects, $snippets, $formatters, $language);
	}

	protected function getTemplatingObjects() {
		return array(
			'email'   => $this,
			'app'     => $this->app,
			'request' => $this->request,
			'user'    => $this->app->getPrincipal(),
		);
	}

	protected function getTemplatingSnippets() {
		return array();
	}

	protected function getTemplatingFormatters() {
		return array(
			'date'  => new  \TgUtils\Templating\DateFormatter(WFW_TIMEZONE),
			'price' => new  \TgUtils\Templating\CurrencyFormatter(),
			'i18n'  => new  \TgUtils\Templating\I18nFormatter(),
		);
	}

	public function setLanguage($language) {
		$this->language = $language;
	}

	protected function getLanguage() {
		if ($this->language != NULL) {
			return $this->language;
		}
		return $this->request->language;
	}
}

