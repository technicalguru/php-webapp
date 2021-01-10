<?php

namespace WebApp\BootstrapTheme;

class PaginationRenderer extends \WebApp\DefaultTheme\PaginationRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	protected function renderPaginationStart() {
		$this->setAttribute('aria-label', 'Page Navigation');
		return $this->renderStartTag('nav').'<ul class="pagination">';
	}

	protected function renderPaginationEnd() {
		return '</ul>'.$this->renderEndTag('nav');
	}

	protected function renderPageNavLink($label, $pageIndex, $isEnabled, $isActive) {
		return '<li class="page-item'.($isActive ? ' active' : '').'">'.
				'<a class="page-link" href="?'.$this->getParams($pageIndex).'" aria-label="'.htmlentities($label).'">'.$label.'</a>'.
			 '</li>';
	}
}

