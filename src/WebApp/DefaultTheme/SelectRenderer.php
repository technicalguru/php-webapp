<?php

namespace WebApp\DefaultTheme;

use \TgI18n\I18N;

class SelectRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc    = $this->renderStartTag('select');
		$value = $this->component->getAttribute('value', TRUE);
		foreach ($this->component->getOptions() AS $key => $label) {
			$selected = $value == $key ? ' selected="selected"' : '';
			$rc .= '<option value="'.htmlentities($key).'"'.$selected.'>'.I18N::_($label).'</option>';
		}
		$rc .= $this->renderEndTag('select');
		return $rc;
	}
}

