<?php

namespace WebApp\Component;

class Pagination extends Component {

	public $totalCount;
	public $itemsPerPage;
	public $pageNumber;
	public $firstPage;
	public $firstItem;
	public $lastPage;
	public $pageParam;
	public $keepParams;
	public $showAll;

	public function __construct($parent, $totalItemCount, $itemsPerPage, $pageNumber, $pageParam = 'page') {
		parent::__construct($parent);
		$this->totalCount   = $totalItemCount;
		$this->itemsPerPage = $itemsPerPage;
		$this->pageNumber   = $pageNumber;
		$this->pageParam    = $pageParam;
		// Calculate now
		$this->firstPage    = 0;
		$this->firstItem    = $this->itemsPerPage * $pageNumber;
		$this->lastPage     = intval(($this->totalCount-1) / $this->itemsPerPage);
		$this->lastItem     = $this->pageNumber == $this->lastPage ? $this->totalCount-1 : ($this->pageNumber+1) * $this->itemsPerPage - 1;
		$this->keepParams   = array('filter', 'search', 'itemsPerPage');

		// Special case: showAll
		$this->showAll      = \TgUtils\Request::getRequest()->getParam('showAll') == 'showAll';
		if ($this->showAll) {
			$this->firstItem    = 0;
			$this->lastItem     = $this->totalCount-1;
		}
	}

	public function addKeepParams($mixed) {
		if (!is_array()) $this->keepParams[] = $mixed;
		else $this->keepParams = array_merge($this->keepParams, $mixed);
	}

	public function hasMultiplePages() {
		return $this->totalCount > $this->itemsPerPage;
	}

	public function getParams($pageIndex = -1) {
		if ($pageIndex < 0) $pageIndex = $this->pageNumber;
		$rc = urlencode($this->pageParam).'='.$pageIndex;
		if (!isset($this->keptParams)) {
			$this->keptParams = $this->getKeptParamString();
		}
		return $rc.$this->keptParams;
	}

	public function getKeptParamString() {
		$request = \TgUtils\Request::getRequest();
		$keptParams = '';
		foreach ($this->keepParams AS $param) {
			$value = $request->getGetParam($param, NULL);
			if ($value != NULL) {
				if (is_string($value)) {
					$keptParams .= '&'.urlencode($param).'='.urlencode($value);
				} else if (is_array($value)) {
					foreach ($value AS $v) {
						$keptParams .= '&'.urlencode($param).'[]='.urlencode($v);
					}
				}
			}
		}
		return $keptParams;
	}

}
