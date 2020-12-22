<?php

namespace WebApp\DefaultTheme;

class VerticalFormRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('vertical');
	}

	public function render() {
		$rc  = $this->renderStartTag($this->tagName);
		$rc .= $this->renderFormChildren($this->component->getChildren());
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	public function renderFormChildren($children) {
		$rc = '';
		foreach ($children AS $child) {
			$rc .= $this->renderFormChild($child);
		}
		return $rc;
	}

	public function renderFormChild($child) {
		$rc = '';
		if (is_a($child, 'WebApp\\Component\\FormElement')) {
			$rc .= $this->renderFormElement($child);
		} else {
			$rc .= $this->theme->renderComponent($child);
		}
		return $rc;
	}

	public function renderFormElement($child) {
		$error = $child->getError();

		$rc = '<div class="form-group'.($error != NULL ? ' has-error' : '').'" id="form-group-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<div class="form-label"><label for="'.htmlentities($child->getId()).'">'.$label.'</label></div>';
		}
		$rc .= '<div class="form-element">'.$this->theme->renderComponent($child).'</div>';
		$help = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<div class="form-help">'.$help.'</div>';
		}
		if ($error != NULL) {
			$rc .= '<div class="form-error">'.$error.'</div>';
		}
		$rc .= '</div>';
		return $rc;
	}
}

