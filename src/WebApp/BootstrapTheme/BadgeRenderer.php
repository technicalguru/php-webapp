<?php

namespace WebApp\BootstrapTheme;

class BadgeRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$this->addClass('badge');
		$this->addClass('badge-'.$this->component->getType());
		$this->addClass('ml-1');
		return $this->renderStartTag('span').
		          $this->component->getText().
		       $this->renderEndTag('span');
	}
}

