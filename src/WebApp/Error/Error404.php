<?php

namespace WebApp\Error;

class Error404 extends \WebApp\Page {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getTitle() {
		return 'Page Not Found';
	}

	public function getMain() {
		header('HTTP/1.1 404 Not Found');
		return 'We are sorry but we couldn\'t find the page you requested. Please, re-check the URL.';
	}
}

