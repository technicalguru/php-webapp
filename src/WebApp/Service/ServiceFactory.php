<?php

namespace WebApp\Service;

class ServiceFactory {

	protected $app;
	protected $services;

	public function __construct($app) {
		$this->app      = $app;
		$this->services = array();
	}

	public function get($name) {
		if (!isset($this->services[$name])) {
			$this->services[$name] = $this->create($name);
		}
		return $this->services[$name];
	}

	protected function create($name) {
		return NULL;
	}
}

