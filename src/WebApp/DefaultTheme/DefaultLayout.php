<?php

namespace WebApp\DefaultTheme;

/** A basic layout at all */
class DefaultLayout extends \WebApp\Layout {

	public function __construct($theme, $page) {
		parent::__construct($theme, $page);
	}

	protected function renderLinks() {
		$rc  = '<link rel="stylesheet" href="'.\WebApp\Utils::getCssBaseUrl().'/app.css" rel="stylesheet" type="text/css">'.
		       '<link rel="stylesheet" href="'.\TgFontAwesome\FontAwesome::getUri().'" rel="stylesheet" type="text/css">';
		$rc .= parent::renderLinks();
		return $rc;
	}
}

