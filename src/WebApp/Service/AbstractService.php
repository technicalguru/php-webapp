<?php

namespace WebApp\Service;

class AbstractService implements Service {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
	}

}

