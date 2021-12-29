<?php

namespace WebApp\BootstrapTheme\VerticalForm;

class VerticalFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	public function __construct($theme) {
		parent::__construct($theme);
	}

	public function getRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme\VerticalForm', $component);
		return $rc;
	}
}
