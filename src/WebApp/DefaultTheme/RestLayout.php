<?php

namespace WebApp\DefaultTheme;

/** Returns the utput of the page as a REST JSON object or array */
class RestLayout extends \WebApp\Layout {

	public function __construct($theme, $page) {
		parent::__construct($theme, $page);
	}

	public function renderPage() {
		header('Content-Type: application/json');
		$rc = $this->page->getMain();
		if ($rc == NULL) $rc = '';
		if (!is_object($rc) || !is_a($rc, 'WebApp\\RestResult')) {
			$rc = \WebApp\RestResult::success($rc);
		}
		if (!is_string($rc)) $rc = json_encode($rc);
		return $rc;
	}
}

