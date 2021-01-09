<?php

namespace WebApp\Error;

class Error404 extends \WebApp\Page {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getTitle() {
		return 'page404_title';
	}

	public function getMain() {
		header('HTTP/1.1 404 Not Found');
		$rc = new \WebApp\Component\MainContent($this);
		$rc->addClass('text-center');
		// TODO Add this text in white on black image with broken glass
		new \WebApp\Component\Title($rc, 'page404_title');
		new \WebApp\Component\Subtitle($rc, 'page404_subtitle');
		$p = new \WebApp\Component\Paragraph($rc, 'page404_description');
		$p->addClass('small');
		return $rc;
	}
}

