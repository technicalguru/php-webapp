<?php

namespace WebApp\Email;

class AbstractSnippet implements \TgUtils\Templating\Snippet {

	public function getOutput($processor, $params) {
		if ($processor->getStyle() == \TgEmail\Email::HTML) return $this->getHtml($processor, $params);
		return $this->getText($processor, $params);
	}

	protected function getHtml($processor, $params) {
		return '';
	}

	protected function getText($processor, $params) {
		return '';
	}

}
