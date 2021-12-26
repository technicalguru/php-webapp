<?php

namespace WebApp\DefaultTheme;

class InlineFormRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('horizontal');
	}

	public function render() {
		$rc  = $this->renderStartTag($this->tagName);
		$rc .= $this->renderFormChildren($this->component->getChildren());
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	public function renderFormChildren($children) {
		// for each element
		foreach ($children AS $child) {
			$rc .= $this->renderFormChild($child);
		}
		return $rc;
	}

	public function renderFormChild($child) {
		$rc = '';
		if (is_a($child, 'WebApp\\Component\\FormElement')) {
			$rc .= $this->renderFormElement($child);
		} else if (is_a($child, 'WebApp\\Component\\FieldSet')) {
			$rc .= $this->theme->renderComponent($child);
		} else {
			$rc .= '<span class="form-child" id="form-child-'.$child->getId().'">';
			$rc .= $this->theme->renderComponent($child);
			$rc .= '</span>';
		}
		return $rc;
	}

	public function renderFormElement($child) {
		$error = $child->getError();

		$rc = '<span class="form-child'.($error != NULL ? ' has-error' : '').'" id="form-child-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'">'.$label.'</label>';
		}
		$rc .= '<span class="form-element">'.$this->theme->renderComponent($child).'</span>';
		$help = $child->getHelp();
		if ($help != NULL) {
			// TODO Unclear how to do
			// $rc .= '<div class="form-help">'.$help.'</div>';
		}
		if ($error != NULL) {
			// TODO Unclear how to do
			// $rc .= '<div class="form-error">'.$error.'</div>';
		}
		$rc .= '</span>';
		return $rc;
	}

}

