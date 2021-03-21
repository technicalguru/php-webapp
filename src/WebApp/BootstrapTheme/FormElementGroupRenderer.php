<?php

namespace WebApp\BootstrapTheme;

class FormElementGroupRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-element-group');
	}

	public function render() {
		$error = $this->component->getError();
		if ($error != NULL) {
			$this->addClass('has-error');
		}
		$rc = parent::render();
		if ($error != NULL) {
			$rc .= '<div class="invalid-feedback" style="display: block">'.$error.'</div>';
		}
		return $rc;
	}

	protected function renderChild($child) {
		$rc = '';
		if (is_a($child, 'WebApp\\Component\\Checkbox') || is_a($child, 'WebApp\\Component\\Radio')) {
			$rc = $this->renderCheckbox($child);
		} else {
			$rc = parent::renderChild($child);
		}
		return $rc; 
	}

	public function renderCheckbox($child) {
		$error = $child->getError();
		$rc    = '<div class="form-check'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
		$rc   .= $this->theme->renderComponent($child);

		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= ' &nbsp;<label for="'.htmlentities($child->getId()).'" class="form-check-label">'.$label.'</label>';
		}
		$rc .= '</div>';
		return $rc;
	}

}

