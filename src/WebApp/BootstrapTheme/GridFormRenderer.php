<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class GridFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
	}

	protected function getComponentSizeClasses($child) {
		$annotation = explode(' ', $this->searchAnnotation($child, 'grid-form/component-size', 'sm-12 md-8 lg-10'));
		return 'col-'.implode(' col-', $annotation);
	}

	protected function searchAnnotation($child, $key, $default) {
		$rc = $child->getAnnotation($key);
		if ($rc == NULL) {
			$parent = $child->getParent();
			if ($parent != NULL) return $this->searchAnnotation($parent, $key, $default);
			return $default;
		}
		return $rc;
	}

	public function render() {
		$rc  = $this->renderStartTag($this->tagName);
		if ($this->component->hasFieldSets()) {
			$rc .= $this->renderFieldSets();
		}
		$rc .= $this->renderFormChildren($this->component->getChildren());

		if ($this->hasRow) $rc .= '</div>';
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	public function renderFieldSets() {
		// Construct the components
		$tabSet = new \WebApp\Component\TabSet(NULL, $this->component->getId().'fieldsets');
		$tabSet->addClass('tabbed-fieldsets');
		foreach ($this->component->getFieldSets() AS $fieldSet) {
			if ($fieldSet->isVisible()) {
				$tab = $tabSet->createTab($fieldSet->getId(), $fieldSet->getLabel(), $fieldSet);
				$tab->addClass('p-4');
			}
		}

		// Render them
		return $this->theme->renderComponent($tabSet);
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

		if (is_a($child, 'WebApp\\Component\\FormElement') || is_a($child, 'WebApp\\Component\\I18nFormElement')) {
			if ($child->getAnnotation('grid-form/new-row', FALSE) || !$this->hasRow) {
				if ($this->hasRow) $rc .= '</div>';
				$rc .= '<div class="form-row">';
				$this->hasRow = TRUE;
			}

			if (is_a($child, 'WebApp\\Component\\Checkbox')) {
				$rc .= $this->renderCheckbox($child);
			} else if (is_a($child, 'WebApp\\Component\\HiddenInput')) {
				$rc .= $this->theme->renderComponent($child);
			} else if (is_a($child, 'WebApp\\Component\\FileInput')) {
				$rc .= $this->renderFileInput($child);
			} else {
				$rc .= $this->renderGeneralFormChild($child);
			}
		} else if (is_a($child, 'WebApp\\Component\\Button') || is_a($child, 'WebApp\\Component\\Link')) {
			if ($this->hasRow) {
				$rc .= '</div>';
				$this->hasRow = FALSE;
			}
			$rc .= $this->theme->renderComponent($child);
		} else {
			$rc .= '<div class="form-row" id="form-row-'.$child->getId().'">';
			$rc .= $this->theme->renderComponent($child);
			$rc .= '</div>';
		}
		return $rc;
	}

	public function renderGeneralFormChild($child) {
		$rc = '';

		$error = $child->getError();
		$rc    = '<div class="form-group '.$this->getComponentSizeClasses($child).($error != NULL ? ' has-error' : '').'" id="form-group-'.$child->getId().'">';
		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'">'.$label.'</label>';
		} else {
			$rc .= '<label for="'.htmlentities($child->getId()).'"></label>';
		}
		if ($error != NULL) {
			$child->addClass('is-invalid');
			$child->addAttribute('aria-describedby', 'validationFeedback-'.$child->getId());
		}
		$rc .= $this->theme->renderComponent($child);
		$help = $child->getHelp();
		if ($help != NULL) {
			$rc .= '<small class="form-text text-muted">'.$help.'</small>';
		}
		$error = $child->getError(); // Could have been rendered already
		if ($error != NULL) {
			$rc .= '<div id="validationFeedback-'.$child->getId().'" class="invalid-feedback">'.$error.'</div>';
		}
		$rc .= '</div>';

		return $rc;
	}

	public function renderCheckbox($child) {
		$child->addClass('form-check-input');
		$error = $child->getError();
		$rc    = '<div class="form-group" id="form-group-'.$child->getId().'">'.
		            '<div class="form-check">'.
		               $this->theme->renderComponent($child);

		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= ' &nbsp;<label for="'.htmlentities($child->getId()).'" class="form-check-label">'.$label.'</label>';
		}
		$rc    .=   '</div>'.
		          '</div>';
		return $rc;
	}

	public function renderFileInput($child) {
		$child->addClass('custom-file-input');
		$rc = '<div class="custom-file">'.
		         $this->theme->renderComponent($child);
		$label = $child->getLabel();
		if ($label == NULL) $label = I18N::_('browse_file');
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'" class="custom-file-label">'.$label.'</label>';
		}
		$rc .= '</div>';
		return $rc;
	}
}

