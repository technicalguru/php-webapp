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

	public function __construct($parent, $totalItemCount, $itemsPerPage, $pageNumber, $pageParam = 'page') {
		parent::__construct($parent);
		$this->totalCount   = $totalItemCount;
		$this->itemsPerPage = $itemsPerPage;
		$this->pageNumber   = $pageNumber;
		// Calculate now
		$this->firstPage    = 0;
		$this->firstItem    = $this->itemsPerPage * $pageNumber;
		$this->lastPage     = intval(($this->totalCount-1) / $this->itemsPerPage);
		$this->keepParams   = array('filter', 'search', 'itemsPerPage');
	}

	public function addKeepParams($mixed) {
		if (!is_array()) $this->keepParams[] = $mixed;
		else $this->keepParams = array_merge($this->keepParams, $mixed);
	}

}
