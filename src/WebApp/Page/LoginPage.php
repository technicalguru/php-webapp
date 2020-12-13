<?php

namespace WebApp\Page;

use WebApp\Component\Paragraph;
use WebApp\Component\Table;

class LoginPage extends \WebApp\Page {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getTitle() {
		return 'Login';
	}

	public function getRequiredRight() {
		return \WebApp\DataModel\UserRole::ROLE_USER;
	}

	public function getPublicMain() {
		$rc = new \WebApp\Component\MainContentContainer($this);
		new \WebApp\Component\Title($rc, 'login_title');
		$rc->addChild($this->getMessages());
		$rc->addChild($this->getLoginForm());

		return $rc;
	}

	public function getProtectedMain() {
		return array();
	}
}

