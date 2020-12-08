<?php

namespace WebApp\DefaultTheme;

class WrapperRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc  = '';
		if ($this->component->getBefore() != NULL) {
			$rc .= $this->theme->renderComponent($this->component->getBefore());
		}
		$rc .= parent::render();
		if ($this->component->getAfter() != NULL) {
			$rc .= $this->theme->renderComponent($this->component->getAfter());
		}
		return $rc;
	}
}

