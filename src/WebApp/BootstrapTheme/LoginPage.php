<?php

namespace WebApp\BootstrapTheme;

use WebApp\Component\Alert;
use WebApp\Utils;

class LoginPage extends \WebApp\Page\LoginPage {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getPublicMain() {
		$rc = new \WebApp\Component\MainContent($this);
		$panel = new \WebApp\Component\Jumbotron($rc);
		$title = new \WebApp\Component\Title($panel, 'login_title');
		$title->setStyle('margin-top', '0');
		$title->setStyle('margin-bottom', '0.5rem');
		$lead  = new \WebApp\Component\Subtitle($panel, 'please_login');
		$panel->addChild('<hr class="my-4">');
		$panel->addChild($this->getMessages());
		$panel->addChild($this->getLoginForm());
		return $rc;
	}

	protected function getLoginForm() {
		$rc = array();
		$form   = new \WebApp\Component\Form($this, 'loginForm', \WebApp\Component\Form::HORIZONTAL);
		$form->setMethod('POST');
		$form->setAction($this->request->originalPath);

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

		$return =  $this->request->getParam('return');
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
		if ($this->app->getPageLink('forgot_password') != NULL) {
			$link = $this->app->router->getCanonicalPath($this->app->getPageLink('forgot_password'));
			$forgot = new \WebApp\Component\Div($this, new \WebApp\Component\Link($this, $link, 'Passwort vergessen?'));
			$forgot->addClass('small');
			$forgot->setStyle('margin-top', '1em');
			$rc[] = $forgot;
		}
		return $rc;
	}
}
