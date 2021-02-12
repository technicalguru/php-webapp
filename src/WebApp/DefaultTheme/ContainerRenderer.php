<?php

namespace WebApp\DefaultTheme;

class ContainerRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component, $tagName = NULL) {
		parent::__construct($theme, $component);
		$this->tagName = $tagName;
	}

	public function render() {
		$rc = '';
		if ($this->tagName != NULL) $rc .= $this->renderStartTag($this->tagName);
		$rc .= $this->renderChildren();
		if ($this->tagName != NULL) $rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	protected function renderChildren() {
		$rc = '';
		foreach ($this->component->getChildren() AS $child) {
			$rc .= $this->renderChild($child);
		}
		return $rc;
	}

	protected function renderChild($child) {
		return $this->theme->renderComponent($child);
	}
}

