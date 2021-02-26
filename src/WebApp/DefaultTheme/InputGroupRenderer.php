<?php

namespace WebApp\DefaultTheme;

class InputGroupRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}


	public function render() {
		$rc = $this->renderStartTag('div');
		$prepend = $this->component->getPrepend();
		if ($prepend != NULL) {
			$rc .= '<div class="input-group-prepend">'.
			       $this->theme->renderComponent($prepend).
			       '</div>';
		}
		$rc .= $this->renderChildren();
		$append = $this->component->getAppend();
		if ($append != NULL) {
			$rc .= '<div class="input-group-append">'.
			       $this->theme->renderComponent($append).
			       '</div>';
		}
		$rc .= $this->renderEndTag('div');
		return $rc;
	}
}

