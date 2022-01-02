<?php

namespace WebApp\DefaultTheme;

class FormCheckRenderer extends InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc = parent::render();
		$label = $this->component->getLabel();
		if ($label != NULL) {
			$classes = $this->component->getLabelClass();
			$rc .= '<label class="'.$classes.'" for="'.htmlentities($this->component->getId()).'">'.$label.'</label>';
		}
		return $rc;
	}
}

