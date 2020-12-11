<?php

namespace WebApp\BootstrapTheme;

use WebApp\Component\Alert;

class LoginPage extends \WebApp\Page\LoginPage {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getPublicMain() {
		$rc = new \WebApp\Component\Div($this);
		$rc->addClass('jumbotron');
		$rc->setStyle('margin-top', '1em');
		$title = new \WebApp\Component\Title($rc, 'login_title');
		$title->setStyle('margin-top', '0');
		$title->setStyle('margin-bottom', '0.5rem');
		$lead  = new \WebApp\Component\Subtitle($rc, 'please_login');
		$rc->addChild('<hr class="my-4">');
		$rc->addChild($this->getMessages());
		$rc->addChild($this->getLoginForm());
		return $rc;
	}

	protected function getLoginForm() {
		$rc = array();
		$form   = new \WebApp\Component\Form($this, 'loginForm', \WebApp\Component\Form::HORIZONTAL);
		$form->setMethod('POST');
		$form->setAction($this->request->path);

		$userid = $this->request->getPostParam('userid', '');
		$user   = new \WebApp\Component\TextInput($form, 'userid', $uid);
		$user->setLabel('login_userid_label');
		$user->setPlaceholder('login_userid_placeholder');
		$user->setHelp('login_userid_help');

		$pass   = new \WebApp\Component\PasswordInput($form, 'password');
		$pass->setLabel('login_password_label');
		$pass->setPlaceholder('login_password_placeholder');
		$pass->setHelp('login_password_help');

		$persist = new \WebApp\Component\Checkbox($form, 'persist', '1');
		$persist->setLabel('persist_login_label');

		$return =  $this->request->getGetParam('return');
		if ($return != NULL) {
			$returnUri = parse_url($return);
			if (isset($returnUri['query'])) {
				parse_str($returnUri['query'], $queryParams);
				if (isset($queryParams['logout'])) {
					unset($queryParams['logout']);
				}
				$return = $returnUri['path'];
				if (count($queryParams) > 0) {
					$return .= '?'.http_build_query($queryParams);
				}
			}
			new \WebApp\Component\HiddenInput($form, 'return', $return);
		}

		$submit = new \WebApp\Component\Button($form, 'button_login_label');
		$submit->setType('submit');
		$submit->setName('action');
		$submit->setValue('login');
		$submit->addClass('btn-primary');

		$rc[] = $form;
		return $rc;
	}
}
