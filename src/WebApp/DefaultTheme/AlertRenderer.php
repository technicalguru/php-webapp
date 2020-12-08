<?php

namespace WebApp\DefaultTheme;

class AlertRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$this->addClass('alert');
		$this->addClass($this->component->getType());
		$rc  = $this->renderStartTag('div');
		$title = $this->component->getTitle();
		$desc  = $this->component->getDescription();
		if ($title != NULL) $rc .= '<h4>'.$title.'</h4>';
		if ($desc  != NULL) $rc .= '<p>'.$desc.'</p>';
		$rc .= $this->renderChildren().
		       $this->renderEndTag('div');
		return $rc;
	}
}

