<?php

namespace WebApp\DefaultTheme;

class HorizontalFormRenderer extends ContainerRenderer {

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
		$rc = '<table>';
		// for each element
		foreach ($children AS $child) {
			$rc .= $this->renderFormChild($child);
		}
		$rc .= '</table>';
		return $rc;
	}

	public function renderFormChild($child) {
		$rc = '';
		if (is_a($child, 'WebApp\\Component\\FormElement')) {
			$rc .= $this->renderFormElement($child);
		} else if (is_a($child, 'WebApp\\Component\\FieldSet')) {
			$rc .= $this->theme->renderComponent($child);
		} else {
			$rc .= '<tr class="form-row" id="form-row-'.$child->getId().'"><td colspan="2">';
			$rc .= $this->theme->renderComponent($child);
			$rc .= '</td></tr>';
		}
		return $rc;
	}

	public function renderFormElement($child) {
		$error = $child->getError();

		$rc = '<tr class="form-row'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<th><label for="'.htmlentities($child->getId()).'">'.$label.'</label></th>';
		} else {
			$rc .= '<th></th>';
		}
		$rc .= '<td><div class="form-element">'.$this->theme->renderComponent($child).'</td>';
		$help = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<div class="form-help">'.$help.'</div>';
		}
		if ($error != NULL) {
			$rc .= '<div class="form-error">'.$error.'</div>';
		}
		$rc .= '</td></tr>';
		return $rc;
	}

}

