<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;

class VerticalFormRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'form');
	}

	public function render() {
		$this->theme->pushRendererBuilder(new VerticalForm\VerticalFormRendererBuilder($this->theme, $this));
		$rc  = parent::render();
		$this->theme->popRendererBuilder();
		return $rc;
	}

/*
	public function renderFileInput($child) {
		$child->addClass('custom-file-input');
		$rc = '<div class="custom-file">'.
		         $this->theme->renderComponent($child);
		$label = $child->getLabel();
		if ($label == NULL) $label = I18N::_('browse_file');
		if ($label != NULL) {
			$rc .= '<label for="'.htmlentities($child->getId()).'" class="custom-file-label">'.$label.'</label>';
		}
		$rc .= '</div>';
		return $rc;
	}

*/
}

