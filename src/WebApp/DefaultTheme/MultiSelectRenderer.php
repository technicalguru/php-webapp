<?php

namespace WebApp\DefaultTheme;

use \TgI18n\I18N;

class MultiSelectRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->setAttribute('multiple', 'multiple', TRUE);
		$this->addClass('multiselect');
	}

	public function render() {
		$rc     = $this->renderStartTag('select');
		$values = $this->component->getValues();
		foreach ($this->component->getOptions() AS $key => $label) {
			$selected = in_array($key, $values) ? ' selected="selected"' : '';
			$rc .= '<option value="'.htmlentities($key).'"'.$selected.'>'.I18N::_($label).'</option>';
		}
		$rc .= $this->renderEndTag('select');
		return $rc;
	}
}

