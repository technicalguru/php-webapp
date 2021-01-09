<?php

namespace WebApp\DefaultTheme;

class FieldSetRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'div');
	}

	protected function renderChildren() {
		$rc = '';

		// We need the FormRenderer (Vertical/Horizontal/Inline)
		$form = $this->component->getParent();
		if (is_a($form, 'WebApp\\Component\\Form')) {
			$formRenderer = $this->theme->getRenderer($form);
			$rc .= $formRenderer->renderFormChildren($this->component->getChildren());
		} else {
			$rc .= parent::renderChildren();
		}
		return $rc;
	}
}
