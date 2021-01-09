<?php

namespace WebApp\BootstrapTheme;

class I18nFormElementRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$languages = $this->component->getLanguages();
		$cId       = $this->component->getId();
		if (count($languages) > 1) {
			$tabSet = new \WebApp\Component\TabSet(NULL, $cId);
			$tabSet->removeClass('pt-4');
			$tabSet->removeClass('pb-4');
			$tabSet->addNavLinkClass('i18n-form-element');
			foreach ($languages AS $key => $label) {
				$id    = $cId.'-'.$key;
				$error = $this->component->getError($key);
				$elem  = $this->createFormElement($key, $id);
				if (is_object($elem)) {
					$elem->setValue($this->component->getValue($key));
					$elem->setError($error);
				}
				$tab  = $tabSet->createTab($key, $label, $elem);
				if ($error != NULL) {
					$tab->addNavLinkClass('text-danger');
				}
			}
			return $this->theme->renderComponent($tabSet);
		} else if (count($languages) == 1) {
			// Single Rendering
			$key = array_keys($languages)[0];
			$this->renderComponent($key, $this->component->getId());
		} else {
			return 'Cannot render without language';
		}
	}

	protected function createFormElement($languageKey, $id) {
		return '<span class="text-danger">Error! Renderer not implemented</span>';
	}
}
