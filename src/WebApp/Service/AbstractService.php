<?php

namespace WebApp\Service;

class AbstractService implements Service {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
	}

	protected function svc($name) {
		return $this->app->svc($name);
	}

	protected function dao($name) {
		return $this->app->dao($name);
	}
}

