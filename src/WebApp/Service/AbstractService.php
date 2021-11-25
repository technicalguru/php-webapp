<?php

namespace WebApp\Service;

class AbstractService implements Service {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
		$i18n      = $this->getTranslations();
		if (($i18n != NULL) && is_array($i18n) && (count($i18n)>0)) {
			\TgI18n\I18N::addValues($i18n);
		}
	}

	protected function svc($name) {
		return $this->app->svc($name);
	}

	protected function dao($name) {
		return $this->app->dao($name);
	}

	protected function getTranslations() {
		return array();
	}
}

