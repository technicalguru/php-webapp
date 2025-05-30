<?php

namespace WebApp\BootstrapTheme\InlineForm;

use TgI18n\I18N;
use TgUtils\Date;
use TgUtils\DateRange;

class DateRangeInputRenderer extends InputRenderer {

	public $period;

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->theme->addFeature(\WebApp\BootstrapTheme\BootstrapTheme::DATERANGEPICKER);
		$this->addClass('webappdaterange');
		$this->component->setType('text');
	}

	public function render() {
		$options = $this->createOptions();
		$this->setData('options', $options);
		$this->setRangeData();
		return parent::render();
	}

	protected function createOptions() {
		$rc = array(
			'showDropdowns'       => $this->component->showDropdowns(), 
			'alwaysShowCalendars' => $this->component->alwaysShowCalendars(),
			'locale'              => $this->createLocale(),
			'startDate'           => $this->renderStartDate(),
			'endDate'             => $this->renderEndDate(),
		);
		//return str_replace(array('"$$', '$$"'), array('', ''), json_encode($rc));
		return json_encode($rc);
	}

	protected function setRangeData() {
		$this->setData('rangedefs', json_encode(array(
			I18N::_('today')        => '[moment(), moment()]', 
			I18N::_('yesterday')    => '[moment().subtract(1, \'days\'), moment().subtract(1, \'days\')]', 
			I18N::_('last_7_days')  => '[moment().subtract(6, \'days\'), moment()]', 
			I18N::_('last_30_days') => '[moment().subtract(29, \'days\'), moment()]', 
			I18N::_('this_month')   => '[moment().startOf(\'month\'), moment().endOf(\'month\')]', 
			I18N::_('last_month')   => '[moment().subtract(1, \'month\').startOf(\'month\'), moment().subtract(1, \'month\').endOf(\'month\')]'
		)));
	}

	protected function createLocale() {
		$rc = array(
			"format"           => I18N::_('daterange_format'), //"MM/DD/YYYY",
			"separator"        => ' - ',
			"applyLabel"       => I18N::_("apply_label"),
			"cancelLabel"      => I18N::_("cancel_label"),
			"fromLabel"        => I18N::_("from_label"),
			"toLabel"          => I18N::_("to_label"),
			"customRangeLabel" => I18N::_("custom_label"),
			"weekLabel"        => "W",
			"daysOfWeek"       => $this->createWeekdayNames(),
			"monthNames"       => $this->createMonthNames(),
			"firstDay"         => 1,
		);
		return $rc;
    }

	protected function getPeriod() {
		if ($this->period == NULL) {
			$orig = $this->component->getRange();
			$this->period = new DateRange();
			$this->period->set($orig->getFrom(), $orig->getUntil());
			if ($orig->getFrom()  == NULL) $this->period->setFrom(new Date(time(), WFW_TIMEZONE));
			if ($orig->getUntil() == NULL) $this->period->setUntil(new Date(time(), WFW_TIMEZONE));
		}
		return $this->period;
	}

	protected function renderStartDate() {
		$period = $this->getPeriod();
		return $period->getFrom()->format(I18N::_('daterange_internal_format'), TRUE);
	}

	protected function renderEndDate() {
		$period = $this->getPeriod();
		return $period->getUntil()->format(I18N::_('daterange_internal_format'), TRUE);
	}

	protected function createWeekdayNames() {
		$rc = array();
		foreach (array("sun", "mon", "tue", "wed", "thu", "fri", "sat") AS $k) {
			$rc[] = I18N::_($k);
		}
		return $rc;
	}

	protected function createMonthNames() {
		$rc = array();
		foreach (array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december") AS $k) {
			$rc[] = I18N::_($k);
		}
		return $rc;
	}

}
