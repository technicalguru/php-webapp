<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class InlineFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('form-inline');
	}

	public function render() {
		$rc  = $this->renderStartTag($this->tagName);
		if ($this->component->hasFieldSets()) {
			$rc .= $this->renderFieldSets();
		}
		$rc .= $this->renderFormChildren($this->component->getChildren());
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	public function renderFieldSets() {

		// render each field set
		foreach ($this->component->getFieldSets() AS $fieldSet) {
			$rc  = '<div class="form-fieldset" id="fieldset-'.$this->component->getId().'-'.$fieldSet->getId().'">';
			$rc .= $this->renderFormChildren($fieldSet->getChildren());
			$rc .= '</div>';
		}
		return $rc;
	}

	public function renderFormChildren($children) {
		$rc = '';
		foreach ($children AS $child) {
			// Field sets are rendered different
			if (!is_a($child, 'WebApp\\Component\\FieldSet')) {
				$rc .= $this->renderFormChild($child);
			}
		}
		return $rc;
	}

	public function renderFormChild($child) {
		$rc = '';
		if (is_a($child, 'WebApp\\Component\\FormElement')) {
			if (is_a($child, 'WebApp\\Component\\Checkbox')) {
				$rc .= $this->renderCheckbox($child);
			} else if (is_a($child, 'WebApp\\Component\\HiddenInput')) {
				$rc .= $this->theme->renderComponent($child);
			} else {
				$rc .= $this->renderGeneralFormChild($child);
			}
		} else {
			$child->addClass('mb-2 mr-sm-2');
			$rc .= $this->theme->renderComponent($child);
		}
		return $rc;
	}

	public function renderGeneralFormChild($child) {
		$error = $child->getError();
		$rc    = '<span class="form-child'.($error != NULL ? ' has-error' : '').'" id="form-child-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'" class="sr-only">'.$label.'</label>';
		}
		$child->addClass('mb-2 mr-sm-2');
		$rc .= $this->theme->renderComponent($child);
		$rc .= '</span>';
		return $rc;
	}

	public function renderCheckbox($child) {
		$error = $child->getError();
		$rc    = '<div class="form-check mb-2 mr-sm-2'.($error != NULL ? ' has-error' : '').'" id="form-child-'.$child->getId().'">';
		$rc   .= $this->theme->renderComponent($child);

		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'" class="form-check-label">'.$label.'</label>';
		}
		$rc .= '</div>';
		return $rc;
	}

}

