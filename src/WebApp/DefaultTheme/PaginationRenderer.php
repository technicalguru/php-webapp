<?php

namespace WebApp\DefaultTheme;

use \TgI18n\I18N;

class PaginationRenderer extends \WebApp\Renderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$rc = '';
		if ($this->component->hasMultiplePages()) {
			$rc .= $this->renderPaginationStart();
			if (!$this->component->showAll) {
				$rc .= $this->renderFirstPageLink();
				$rc .= $this->renderPreviousPageLink();

				$firstNumber = $this->component->pageNumber-5;
				if ($firstNumber < $this->component->firstPage) $firstNumber = $this->component->firstPage;
				$lastNumber  = $this->component->pageNumber+5;
				if ($lastNumber > $this->component->lastPage) {
					$lastNumber = $this->component->lastPage;
				}
				for ($i=$firstNumber; $i<=$lastNumber; $i++) {
					$rc .= $this->renderPageLink($i);
				}

				$rc .= $this->renderNextPageLink();
				$rc .= $this->renderLastPageLink();
			}
			$rc .= $this->renderShowAllCheck();
			$rc .= $this->renderPaginationEnd();
		}
		return $rc;
	}

	protected function renderPaginationStart() {
		$this->addClass('pagination');
		return $this->renderStartTag('div');
	}

	protected function renderPaginationEnd() {
		return $this->renderEndTag('div');
	}

	protected function renderFirstPageLink() {
		return $this->renderPageNavLink(I18N::_('first_page_label'), 0, $this->component->pageNumber != $this->component->firstPage, false);
	}

	protected function renderPreviousPageLink() {
		$page = $this->component->pageNumber-1;
		if ($page < $this->component->firstPage) $page = $this->component->firstPage;
		return $this->renderPageNavLink(I18N::_('previous_page_label'), $page , $this->component->pageNumber != $this->component->firstPage, false);
	}

	protected function renderNextPageLink() {
		$page = $this->component->pageNumber+1;
		if ($page > $this->component->lastPage) $page = $this->component->lastPage;
		return $this->renderPageNavLink(I18N::_('next_page_label'), $page , $this->component->pageNumber < $this->component->lastPage, false);
	}

	protected function renderLastPageLink() {
		return $this->renderPageNavLink(I18N::_('last_page_label'), $this->component->lastPage, $this->component->pageNumber < $this->component->lastPage, false);
	}

	protected function renderPageLink($page) {
		return $this->renderPageNavLink($page+1, $page, $this->component->pageNumber != $page, $this->component->pageNumber == $page);
	}

	protected function renderPageNavLink($label, $pageIndex, $isEnabled, $isActive) {
		$params = $this->component->getParams($pageIndex);
		return '<span class="page-item'.($isActive ? ' active' : '').'">'.
				'<a class="page-link" href="?'.$params.'" aria-label="'.htmlentities($label).'">'.$label.'</a>'.
			 '</span>';
	}

	protected function renderShowAllCheck() {
		$checked  = '';
		$pageLink = '?'.$this->component->getParams();
		if ($this->component->showAll) {
			$checked  = ' checked';
		} else {
			$pageLink .= '&showAll=showAll';
		}
		return '<li class="page-item" style="padding:0.5em 1em;"><input id="paginationShowAll" type="checkbox" name="showAll" value="showAll"'.$checked.' onChange="window.location=\''.htmlentities($pageLink).'\';"></input> <label for="paginationShowAll">Show All</label></li>';
	}

}

