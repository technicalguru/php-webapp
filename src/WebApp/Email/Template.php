<?php

namespace WebApp\Email;

class Template {

	public function __construct() {
	}

	public function getTemplate($style, $language) {
		switch ($style) {
		case \TgEmail\Email::HTML: return $this->getHtmlTemplate($language);
		case \TgEmail\Email::TEXT: return $this->getTextTemplate($language);
		}
		return '[Invalid style: '.$style.']';
	}

	public function getHtmlTemplate($language) {
		return '[HTML template not defined]';
	}

	public function getTextTemplate($language) {
		return '[TEXT template not defined]';
	}

}

