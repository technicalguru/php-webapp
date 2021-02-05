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
		$emptyOption = $this->component->getEmptyOption();
		\TgLog\Log::debug('('.$this->component->getId().') emptyOption='.$emptyOption.'  NULL='.($emptyOption === NULL ? 'YES' : 'NO'));
		if ($emptyOption !== NULL) {
			$rc .= self::renderOption('', $emptyOption, $value == '');
		}
		foreach ($this->component->getOptions() AS $key => $label) {
			$rc .= self::renderOption($key, $label, $value == $key);
		}
		$rc .= $this->renderEndTag('select');
		return $rc;
	}

	protected static function renderOption($key, $label, $isSelected) {
		$selected = $isSelected ?  ' selected="selected"' : '';
		return '<option value="'.htmlentities($key).'"'.$selected.'>'.I18N::_($label).'</option>';
	}
}

