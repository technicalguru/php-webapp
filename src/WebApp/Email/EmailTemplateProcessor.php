<?php

namespace WebApp\Email;

class EmailTemplateProcessor extends \TgUtils\Templating\Processor {

	public $style;

	public function __construct($objects = NULL, $snippets = NULL, $formatters = NULL, $language = NULL) {
		parent::__construct($objects, $snippets, $formatters, $language);
		$this->setStyle(\TgEmail\Email::HTML);
	}

	public function setStyle($style) {
		$this->style = $style;
	}

	public function getStyle() {
		return $this->style;
	}

	public function process($s) {
		if (is_object($s)) $s = $s->getTemplate($this->style, $this->language);
		return parent::process($s);
	}
}

