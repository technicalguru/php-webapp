<?php

namespace WebApp\Email;

class AbstractSnippet implements \TgUtils\Templating\Snippet {

	public function getOutput($processor) {
		if ($processor->getStyle() == \TgEmail\Email::HTML) return $this->getHtml($processor);
		return $this->getText($processor);
	}

	protected function getHtml($processor) {
		return '';
	}

	protected function getText($processor) {
		return '';
	}

}
