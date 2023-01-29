<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class I18nFormElement extends CombinedFormElement {

	protected $errors;
	protected $languages;

	public function __construct($parent, $id, $languages, $values = null) {
		parent::__construct($parent, $id, $values);
		$this->setLanguages($languages);
	}

	public function getLanguages() {
		return $this->languages;
	}

	public function setLanguages($values) {
		return $this->languages = $values;
	}

	public function getValue($languageKey = NULL) {
		return I18N::__($this->values, $languageKey);
	}

	public function setValue($languageKey, $value) {
		if (is_int($value)) $value = ''.$value;
		if (is_object($this->values)) $this->values->$languageKey = $value;
		if (is_array($this->values)) $this->values[$languageKey] = $value;
		
	}

	public function setError($languageKey, $value = NULL) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->errors[$languageKey] = $value;
	}

	public function getError($languageKey = NULL) {
		if ($languageKey == NULL) {
			if (is_array($this->errors) && (count($this->errors) > 0)) {
				$languageKey = array_keys($this->errors)[0];
				return I18N::_($this->errors[$languageKey]);
			}
		}
		return isset($this->errors[$languageKey]) ? I18N::_($this->errors[$languageKey]) : NULL;
	}

	public static function getPostValues($name, $languages, $filter = NULL) {
		$rc = array();
		$request = \TgUtils\Request::getRequest();
		foreach ($languages AS $key => $label) {
			$rc[$key] = $request->getPostParam($name.'-'.$key, NULL, $filter);
			if ($rc[$key] != NULL) $rc[$key] = trim($rc[$key]);
		}
		return $rc;
	}
}
