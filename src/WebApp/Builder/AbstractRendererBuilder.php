<?php

namespace WebApp\Builder;

abstract class AbstractRendererBuilder implements RendererBuilder {

	protected $theme;

	public function __construct($theme) {
		$this->theme = $theme;
	}

	public function getRenderer($component) {
		return NULL;
	}
}
