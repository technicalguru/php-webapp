<?php

namespace WebApp\Component;

class YearSelect extends Select {

	protected $options;

	public function __construct($parent, $id, $value = NULL) {
		parent::__construct($parent, $id, $this->createOptions(), $value == NULL ? date('Y') : $value);
	}

	protected function createOptions() {
		$rc = array();
		for ($i=2019; $i<=date('Y'); $i++) {
			$rc[$i] = $i;
		}
		return $rc;
	}

}

