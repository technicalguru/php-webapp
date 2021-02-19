<?php

namespace WebApp\DefaultTheme;

class PlainCheckboxRenderer extends InputRenderer {


	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('plain-checkbox');
	}

	public function render() {
		$rc = parent::render();
		$label = $this->component->getLabel();
		if ($label != NULL) {
			$rc .= '<label for="'.$this->component->getId().'" >'.$label.'</label>';
		}
		return $rc;
	}
}

