<?php

namespace WebApp\BootstrapTheme;

use \TgI18n\I18N;

class RemoteSearchMultiSelectRenderer extends InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
		$this->addClass('remote-search');
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::REMOTESEARCH);
	}

	public function render() {
		$name = $this->component->getName();
		$this->addAttribute('aria-haspopup', 'true');
		$this->addAttribute('data-toggle', 'dropdown');
		$this->addAttribute('data-uri', $this->component->restUri);
		$this->addAttribute('data-name', $name);
		$this->component->setName($name.'-search');
		$this->component->setId($name.'-search');

		$rc = '<div class="dropdown">'.
				  $this->renderStartTag('input').
		          '<div class="dropdown-menu search-dropdown" aria-labelledby="'.$name.'-search">'.
			         '<a class="dropdown-item" href="#">Action</a>'.
			         '<a class="dropdown-item" href="#">Another action</a>'.
			         '<a class="dropdown-item" href="#">Something else here</a>'.
		          '</div>'.
				  '<div id="remote-search-values-'.$name.'" class="remote-search-values">';
		foreach ($this->component->values AS $value => $label) {
			$rc .=   '<span class="badge badge-primary" data-value="'.htmlentities($value).'">'.htmlentities($label);
			if (!in_array($value, $this->component->fixedValues)) {
				$rc .= ' <a onclick="deleteRemoteValue(this);return false;" data-value="'.htmlentities($value).'" data-name="'.$name.'" href="#"><i class="fas fa-times-circle"></i></a>';
			}
			$rc .=   '</span><input type="hidden" name="'.$name.'[]" value="'.htmlentities($value).'">';
		}
		$rc .=    '</div>';
		$rc .= '</div>';
		return $rc;
	}
}

