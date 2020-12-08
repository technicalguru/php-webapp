<?php

namespace WebApp\DefaultTheme;

class VerticalFormRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('vertical');
	}

	public function render() {
		// Render using divs
		$rc = $this->renderStartTag($this->tagName);
		// for each element
		foreach ($this->component->getChildren() AS $child) {
			if (is_a($child, 'WebApp\\Component\\FormElement')) {
				$error = $child->getError();

				$rc .= '<div class="form-group'.($error != NULL ? ' has-error' : '').'" id="form-group-'.$child->getId().'">';
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
			} else {
				$rc .= $this->theme->renderComponent($child);
			}
		}

		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}
}

