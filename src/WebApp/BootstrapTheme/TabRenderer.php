<?php

namespace WebApp\BootstrapTheme;

class TabRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('tab-pane');
		$this->addClass('fade');
	}

	public function render() {
		if ($this->component->isActive()) $this->addClass('active show');
		$rc  = $this->renderStartTag($this->tagName);
		$rc .= $this->renderChildren();
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

}

