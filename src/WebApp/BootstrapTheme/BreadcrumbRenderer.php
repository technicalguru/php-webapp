<?php

namespace WebApp\BootstrapTheme;

class BreadcrumbRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->setAttribute('aria-label', 'breadcrumb');
	}

	public function render() {
		$rc  = $this->renderStartTag('nav').
		       '<ol class="breadcrumb">'.
		          $this->renderChildren().
		       '</ol>'.
		       $this->renderEndTag('nav');
		return $rc;
	}
}

