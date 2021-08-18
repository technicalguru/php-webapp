<?php

namespace WebApp\Component;

use TgUtils\Request;

class SearchFilterBar extends Form {

	public function __construct($parent) {
		parent::__construct($parent, 'searchForm', Form::INLINE);
		$this->setMethod('GET');
		$this->setAction(Request::getRequest()->originalPath);
		$this->searchInput = $this->createSearchInput();
		$this->button = $this->createSubmitButton();
		$this->button->setAttribute('onclick', 'searchFilter.searchSubmit(this); return false');
		$this->createFilters();
	}

	public static function getSearchPhrase() {
		return trim(Request::getRequest()->getParam('search'));
	}

	public static function getFilters() {
		$rc = Request::getRequest()->getParam('filter');
		if (!is_array($rc)) $rc = array();
		return $rc;
	}

	public static function hasFilter($value) {
		return in_array($value, self::getFilters());
	}

	protected function createSearchInput() {
		$rc = new TextInput($this, 'search', self::getSearchPhrase());
		$rc->setLabel('search_filter_label');
		$rc->setPlaceholder('search_placeholder');
		return $rc;
	}

	protected function createFilters() {
		// Default function will take over all relevant values
		$request = Request::getRequest();
		$filters = $request->getParam('filter');
		if (is_string($filters)) {
			new HiddenInput($this, 'filter', $filters);
		} else if (is_array($filters)) {
			foreach ($filters AS $f) {
				$i = new HiddenInput($this, NULL, $f);
				$i->setName('filter[]');
			}
		}
	}

	protected function createSubmitButton() {
		return new SubmitButton($this, 'search_label');
	}

	public function addFilter($value, $label) {
		$check = new Checkbox($this, 'filter[]', $value);
		$check->setLabel($label);
		$check->setChecked(self::hasFilter($value));
		$check->setAttribute('onChange', 'this.form.submit()');
	}

	public static function getParamsWithSearch($value) {
		if (!\TgUtils\Utils::isEmpty($value)) {
			return self::makeParams(trim($value), self::getFilters());
		}
		return self::makeParams(NULL, self::getFilters());
	}

	public static function getParamsWithFilter($value) {
		$filter = self::getFilters();
		if (!in_array($value, $filter)) $filter[] = $value;
		return self::makeParams(self::getSearchPhrase(), $filter);
	}

	public static function getParamsWithoutFilter($value) {
		$filter = array();
		foreach (self::getFilters() AS $f) {
			if ($f != $value) $filter[] = $f;
		}
		return self::makeParams(self::getSearchPhrase(), $filter);
	}

	public static function makeParams($search, $filter) {
		$params = array();
		if (!\TgUtils\Utils::isEmpty($search)) $params[] = 'search='.urlencode(trim($search));
		if (is_array($filter)) {
			foreach ($filter AS $f) {
				$params[] = 'filter[]='.urlencode($f);
			}
		} else if (!\TgUtils\Utils::isEmpty($filter)) {
			$params[] = 'filter[]='.urlencode($filter);
		}
		return implode('&', $params);
	}

}

