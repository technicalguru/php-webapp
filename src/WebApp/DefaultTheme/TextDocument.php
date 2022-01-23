<?php

namespace WebApp\DefaultTheme;

/** Returns the output of the page as a pure text */
class TextDocument extends \WebApp\Layout {

	public function __construct($theme, $page) {
		parent::__construct($theme, $page);
	}

	public function renderPage() {
		header('Content-Type: text/plain');
		$rc = $this->page->getMain();
		if ($rc == NULL) $rc = '';
		if (!is_string($rc)) {
			if (is_array($rc)) $rc = implode("\n", $rc);
			else $rc = 'Invalid content detected.';
		}
		return $rc;
	}
}

