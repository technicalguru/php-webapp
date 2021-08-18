<?php

namespace WebApp\Component;

use TgI18n\I18N;
use TgUtils\Request;

class FilterPanel extends Div {

	protected static $filter;

	public function __construct($parent) {
		parent::__construct($parent);
		$this->addClass('filter-panel');
		$this->form = new Form($this, 'filterForm');
		$this->form->setAction(Request::getRequest()->originalPath);
		$this->addFilterSections();
		$this->addButtons();
	}

	public function addFilterCheckbox($parent, $groupId, $value, $label, $defaultChecked = FALSE) {
		$div = new Div($parent);
		$div->addClass('form-group');
		$cb = new Checkbox($div, 'filter'.ucfirst($groupId).ucfirst($value), $groupId.':'.$value);
		$cb->setName('filter[]');
		$cb->setLabel($label);
		$cb->setAnnotation('webapp/renderer', 'WebApp\\DefaultTheme\\PlainCheckboxRenderer');
		if (self::hasFilter($groupId)) {
			$cb->setChecked(self::isFilterSet($groupId, $value));
		} else {
			$cb->setChecked($defaultChecked);
		}
		return $cb;
	}

	public function addSection($label, $id) {
		$div = new Div($this->form);
		$div->addClass('filter-section');
		$p = new Paragraph($div);
		$p->addClass('section-toggle');
		$l = new Link($p, '#'.$id, strtoupper(I18N::_($label)));
		$l
			->addClass('link-primary')
			->setAttribute('data-toggle', 'collapse')
			->setAttribute('role', 'button')
			->setAttribute('aria-expanded', 'true')
			->setAttribute('aria-controls', $id);

		$rc = new Div($div);
		$rc
			->setId($id)
			->addClass('section-content', 'collapse', 'show');
		return $rc;
	}

	protected function addButtons() {
		$div = new Div($this->form);
		$div->addClass('filter-submit');
		$request = Request::getRequest();
		$search  = $request->getParam('search');
		new HiddenInput($div, 'search', $search);
		$btn = new SubmitButton($div, 'apply_label');
		$btn->setAttribute('onclick', 'searchFilter.filterSubmit(this);return false');
	}

	public static function getFilters($request = NULL) {
		if (self::$filter == NULL) {
			if ($request == NULL) $request = Request::getRequest();
			self::$filter = array();
			foreach ($request->getParam('filter', array()) AS $filter) {
				list($name, $value) = explode(':', $filter, 2);
				self::$filter[$name][] = $value;
			}
		}
		return self::$filter;
	}

	public static function getFilter($name, $request = NULL) {
		$filters = self::getFilters($request);
		if (isset($filters[$name])) return $filters[$name];
		return array();
	}

	public static function isFilterSet($name, $value, $request = NULL) {
		$filters = self::getFilter($name, $request);
		return in_array($value, $filters);
	}

	public static function hasFilter($name, $request = NULL) {
		$filters = self::getFilter($name, $request);
		return count($filters) > 0;
	}

}

