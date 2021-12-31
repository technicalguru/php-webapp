<?php

namespace WebApp\BootstrapTheme;

class InputRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('form-control');
		if ($component->getError() != NULL) $this->addClass('is-invalid');
	}

	public function render() {
		$rc      = '';
		$prepend = $this->component->getPrependContent();
		$append  = $this->component->getAppendContent();
		$isGroup = ($prepend != NULL) || ($append != NULL);

		if ($isGroup) {
			//$rc  = '<div class="input-group mb-2 mr-sm-2">';
			$rc  = '<div class="input-group">';
			if ($prepend != NULL) {
				$rc .= '<div class="input-group-prepend input-group-addon">'.
						 '<span class="input-group-text">'.$prepend.'</span>'.
					   '</div>';
			}
			$rc .= $this->renderStartTag('input');
			if ($append != NULL) {
				$rc .= '<div class="input-group-append input-group-addon">'.
						 '<span class="input-group-text">'.$append.'</span>'.
					   '</div>';
			}
			$rc .= '</div>';
		} else {
			//$this->addClass('mb-2', 'mr-sm-2');
			$rc .= $this->renderStartTag('input');
		}

		return $rc;
	}
}

