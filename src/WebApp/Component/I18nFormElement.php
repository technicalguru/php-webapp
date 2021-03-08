<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class I18nFormElement extends BasicFormElement implements MultiValueComponent {

	protected $errors;
	protected $languages;
	protected $values;

	public function __construct($parent, $id, $languages, $values = null) {
		parent::__construct($parent, $id);
		$this->setValues($values);
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

	public function getValues() {
		return $this->values;
	}

	public function setValue($languageKey, $value) {
		if (is_int($value)) $value = ''.$value;
		if (is_object($this->values)) $this->values->$languageKey = $value;
		if (is_array($this->values)) $this->values[$languageKey] = $value;
		
	}

	public function setValues($values) {
		$this->values = $values;
	}

	public function getErrors() {
		return $this->errors;
	}

	public function setErrors($values) {
		$this->errors = $values;
	}

	public function setError($languageKey, $value) {
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
		return I18N::_($this->errors[$languageKey]);
	}

	public static function getPostValues($name, $languages) {
		$rc = array();
		$request = \TgUtils\Request::getRequest();
		foreach ($languages AS $key => $label) {
			$rc[$key] = $request->getPostParam($name.'-'.$key);
			if ($rc[$key] != NULL) $rc[$key] = trim($rc[$key]);
		}
		return $rc;
	}
}
