<?php

namespace WebApp\Builder;

abstract class AbstractMenuBuilder implements MenuBuilder {

	protected $app;

	public function __construct($app) {
		$this->app = $app;
	}

}

		
