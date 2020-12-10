<?php

namespace WebApp\BootstrapTheme;

use \TgI18n\I18N;

class HorizontalFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('horizontal');
	}

	public function render() {
		// Render using divs
		$rc = $this->renderStartTag($this->tagName);
		// for each element
		foreach ($this->component->getChildren() AS $child) {
			if (is_a($child, 'WebApp\\Component\\FormElement')) {
				if (is_a($child, 'WebApp\\Component\\Checkbox')) {
					$rc .= '<div class="form-check form-group'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
					$rc .= $this->theme->renderComponent($child);

					$label = $child->getLabel();
					if ($label != NULL) {
						$rc .= ' &nbsp;<label for="'.htmlentities($child->getId()).'" class="form-check-label">'.$label.'</label>';
					}
					$rc .= '</div>';
				} else if (is_a($child, 'WebApp\\Component\\HiddenInput')) {
					$rc .= $this->theme->renderComponent($child);
				} else if (is_a($child, 'WebApp\\Component\\FileInput')) {
					$child->addClass('custom-file-input');
					$rc .= '<div class="custom-file">'.
					          $this->theme->renderComponent($child);
					$label = $child->getLabel();
					if ($label == NULL) $label = I18N::_('browse_file');
					if ($label != NULL) {
						$rc .= '<label for="'.htmlentities($child->getId()).'" class="custom-file-label">'.$label.'</label>';
					}
					$rc .= '</div>';
				} else {
					$error = $child->getError();

					$rc .= '<div class="form-group row'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
					$label = $child->getLabel();
					if ($label != NULL) {
						$rc .= '<label for="'.htmlentities($child->getId()).'" class="col-sm-2 col-form-label">'.$label.'</label>';
					} else {
						// TODO
					}
					$rc .= '<div class="col-sm-10 col-md-6 col-lg-4">'.$this->theme->renderComponent($child).'</div>';
					$help = $child->getHelp();
					if ($help != NULL) {
						$rc .= '<small class="form-text text-muted">'.$help.'</small>';
					}
					if ($error != NULL) {
						$rc .= '<div class="invalid-feedback">'.$error.'</div>';
					}
					$rc .= '</div>';
				}
			} else if (is_a($child, 'WebApp\\Component\\Button')) {
				$rc .= $this->theme->renderComponent($child);
			} else {
				$rc .= '<div class="form-group row" id="form-row-'.$child->getId().'">';
				$rc .= $this->theme->renderComponent($child);
				$rc .= '</div>';
			}
		}
		$rc .= '</table>';
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}
}

