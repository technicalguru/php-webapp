<?php

namespace WebApp\DefaultTheme;

class ButtonGroupRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'div');
		$this->addClass('button-group');
	}

	public function render() {
		$rc = $this->renderStartTag($this->tagName);
		foreach ($this->component->getChildren() AS $child) {
			$rc .= $this->theme->renderComponent($child);
		}
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}
}

