<?php

namespace WebApp\BootstrapTheme\InlineForm;

class InlineFormRendererBuilder extends \WebApp\Builder\AbstractRendererBuilder {

	public function __construct($theme) {
		parent::__construct($theme);
	}

	public function getRenderer($component) {
		$rc = $this->searchRendererInNamespace('WebApp\BootstrapTheme\InlineForm', $component);
		return $rc;
	}
}
