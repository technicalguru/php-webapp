<?php

namespace WebApp\Component;

class I18nTextInput extends I18nFormElement {

	protected $placeholders;

	public function __construct($parent, $id, $languages, $values) {
		parent::__construct($parent, $id, $languages, $values);
	}

	protected function createFormElement($languageKey, $id, $label, $value, $error) {
		$rc = new TextInput($this->getParent(), $id, $value);
		\TgLog\Log::debug('value: '.$value, $this->values);
		foreach ($this->getAttributes() AS $name => $v) {
			foreach ($v as $v2) {
				$rc->addAttribute($name, $v2);
			}
		}
		foreach ($this->getStyles() AS $name => $v) {
			$rc->setStyle($name, $v);
		}
		if ($label != NULL) $rc->setLabel($label);
		if ($error != NULL) $rc->setError($error);
		$rc->setHelp($this->getHelp());
		$rc->setName($id);
		return $rc;
	}
}
