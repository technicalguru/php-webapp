<?php

namespace WebApp\BootstrapTheme;

class DynamicFieldRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::DYNAMICFIELDS);
	}

	public function render() {
		$this->addClass('dynamic-fields');
		$this->addAttribute('data-role', 'dynamic-fields');
		$rc = $this->renderStartTag('div').
		// Template
		$rc .= $this->renderRow('IDNUM', NULL, TRUE);
		// Children come here
		foreach ($this->component->getValues() AS $value) {
			$rc .= $this->renderRow($value->id, $value->value, FALSE);
		}
		$rc .= $this->renderEndTag('div');
		return $rc;
	}

	protected function renderRow($idExt, $value, $isTemplate) {
		$rc = '<div class="form-inline">';
		foreach ($this->component->getChildren() AS $child) {
			// The child is a template, so we need the old values
			$id      = $child->getId();
			$name    = $child->getName();
			$style   = $child->getStyle('display');
			$isMulti = is_a($child, 'WebApp\\Component\\MultiValueComponent');
			$origVal = $isMulti ? $child->getValues() : $child->getValue();

			if ($isTemplate) $child->setStyle('display', 'none');
			else if ($value != NULL) {
				if ($id == $this->component->getId().'-id') $child->setValue($idExt);
				else if ($isMulti) $child->setValues($value->$name);
				else $child->setValue($value->$name);
			}
			$child->setId($id.'-'.$idExt);
			$child->setName($name.'[]');
			$rc .= $this->theme->renderComponent($child);

			// Restore properties for next usage
			$child->setId($id);
			$child->setName($name);
			if ($isMulti) $child->setValues($origVal);
			else $child->setValue($origVal);
			$child->setStyle('display', $style);
		}
		$rc .=  '<button class="btn btn-danger" data-role="remove">'.
					'<i class="fas fa-trash"></i>'.
				'</button>'.
				'<button class="btn btn-primary" data-role="add">'.
					'<i class="fas fa-plus-circle"></i>'.
				'</button>'.
			'</div>';
		return $rc;
	}
}

