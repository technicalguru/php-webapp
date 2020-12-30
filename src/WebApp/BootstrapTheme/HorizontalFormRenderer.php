<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class HorizontalFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
		$this->addClass('horizontal');
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
		$rc =    '<nav>'.
		            '<div class="nav nav-tabs nav-fill" id="nav-tab-'.$this->component->getId().'" role="tablist">';
		// render navigation
		foreach ($this->component->getFieldSets() AS $fieldSet) {
			if ($fieldSet->isActive()) {
				$rc .= '<a class="nav-item nav-link active" id="nav-'.$fieldSet->getId().'-tab" data-toggle="tab" href="#nav-'.$fieldSet->getId().'" role="tab" aria-controls="nav-'.$fieldSet->getId().'" aria-selected="true">'.$fieldSet->getLabel().'</a>';
			} else {
				$rc .= '<a class="nav-item nav-link" id="nav-'.$fieldSet->getId().'-tab" data-toggle="tab" href="#nav-'.$fieldSet->getId().'" role="tab" aria-controls="nav-'.$fieldSet->getId().'" aria-selected="false">'.$fieldSet->getLabel().'</a>';
			}
		}
		$rc .=       '</div>'.
		             '<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent-'.$this->component->getId().'">';

		// render each field set
		foreach ($this->component->getFieldSets() AS $fieldSet) {
			if ($fieldSet->isActive()) {
				$rc .= '<div class="tab-pane fade show jumbotron active" id="nav-'.$fieldSet->getId().'" role="tabpanel" aria-labelledby="nav-'.$fieldSet->getId().'-tab">';
			} else {
				$rc .= '<div class="tab-pane fade show jumbotron" id="nav-'.$fieldSet->getId().'" role="tabpanel" aria-labelledby="nav-'.$fieldSet->getId().'-tab">';
			}
			$rc .= $this->renderFormChildren($fieldSet->getChildren());
			$rc .= '</div>';
		}
		$rc .=       '</div>'.
		          '</nav>';
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
			} else if (is_a($child, 'WebApp\\Component\\FileInput')) {
				$rc .= $this->renderFileInput($child);
			} else {
				$rc .= $this->renderGeneralFormChild($child);
			}
		} else if (is_a($child, 'WebApp\\Component\\Button') || is_a($child, 'WebApp\\Component\\Link')) {
			$rc .= $this->theme->renderComponent($child);
		} else {
			$rc .= '<div class="form-group row" id="form-row-'.$child->getId().'">';
			$rc .= $this->theme->renderComponent($child);
			$rc .= '</div>';
		}
		return $rc;
	}

	public function renderGeneralFormChild($child) {
		$error = $child->getError();
		$rc    = '<div class="form-group row'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
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
		return $rc;
	}

	public function renderCheckbox($child) {
		$error = $child->getError();
		$rc    = '<div class="form-check form-group'.($error != NULL ? ' has-error' : '').'" id="form-row-'.$child->getId().'">';
		$rc   .= $this->theme->renderComponent($child);

		$label = $child->getLabel();
		if ($label != NULL) {
			$rc .= ' &nbsp;<label for="'.htmlentities($child->getId()).'" class="form-check-label">'.$label.'</label>';
		}
		$rc .= '</div>';
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

