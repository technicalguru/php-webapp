<?php

namespace WebApp\BootstrapTheme;

class BreadcrumbLinkRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('breadcrumb-item');
	}

	public function render() {
		if ($this->component->isActive()) {
			$this->addClass('active');
		}
		$rc  = $this->renderStartTag('li');
		$link = $this->component->getLink();
		if ($link != NULL) {
			$rc .= '<a href="'.htmlentities($link).'">';
		}
		$rc .= $this->component->getLabel();
		if ($link != NULL) {
			$rc .= '</a>';
		}
		$rc .= $this->renderEndTag('li');
		return $rc;
	}
}

