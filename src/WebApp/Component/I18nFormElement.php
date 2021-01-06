<?php

namespace WebApp\Component;

class I18nFormElement extends I18nHelper {

	protected $name;
	protected $label;
	protected $values;
	protected $help;
	protected $errors;

	public function __construct($parent, $id, $languages, $values) {
		parent::__construct($parent, $id, $languages);
		$this->setName($id);
		$this->setValues($values);
	}

	protected function createComponent($languageKey, $languageLabel) {
		$id    = $this->getId().'-'.$languageKey;
		$label = $this->getLabel();
		if ($label != NULL) {
			$label = \TgI18n\I18N::_($label).' ('.$languageLabel.')';
		}
		$value = $this->getValue($languageKey);
		$error = $this->getError($error);
		return $this->createFormElement($languageKey, $id, $label, $value, $error);
	}

	protected function createFormElement($languageKey, $id, $label, $value, $error) {
		throw new \WebApp\WebAppException('You must implement #createFormElement($languageKey, $id, $label, $value, $error)');
	}

	public function getLabel() {
		return $this->label;
	}

	public function setLabel($value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->label = $value;
	}

	public function getHelp() {
		return $this->help;
	}

	public function setHelp($value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->help = $value;
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
		return \TgI18n\I18N::_($this->errors, $languageKey);
	}

	public function getName() {
		return $this->getAttribute('name', TRUE, $this->getId());
	}

	public function setName($name) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->setAttribute('name', $name);
	}

	public function getValue($languageKey = NULL) {
		return \TgI18n\I18N::__($this->values, $languageKey);
	}

	public function getValues() {
		return $this->values;
	}

	public function setValue($languageKey, $value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		if (is_int($value)) $value = ''.$value;
		if (is_object($this->values)) $this->values->$languageKey = $value;
		if (is_array($this->values)) $this->values[$languageKey] = $value;
		
	}

	public function setValues($values) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->values = $values;
	}

	public function isEnabled() {
		return $this->getAttribute('disabled', TRUE) != 'disabled';
	}

	public function setEnabled($b) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->setAttribute('disabled', $b ? NULL : 'disabled');
	}

	public function isReadOnly() {
		return !$this->isEnabled();
	}

	public function setReadOnly($b) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->setEnabled(!$b);
	}

	public function isRequired() {
		return $this->getAttribute('required', TRUE) == 'required';
	}

	public function setRequired($b) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->setAttribute('required', $b ? 'required' : NULL);
	}

	public static function getPostValues($name, $languages) {
		$rc = array();
		$request = \TgUtils\Request::getRequest();
		foreach ($languages AS $key => $label) {
			$rc[$key] = $request->getPostParam($name.'-'.$key);
		}
		return $rc;
	}
}
