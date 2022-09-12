<?php

namespace WebApp\Component;

class LoginForm extends Div {

	protected $request;
	protected $header;
	protected $body;
	protected $form;
	protected $footer;
	protected $socialLogins;
	protected $return;

	public function __construct($parent, $socialLogins = FALSE, $tfa = FALSE, $return = NULL) {
		parent::__construct($parent);
		$this->request = \TgUtils\Request::getRequest();
		$this->addClass('login-form');
		$this->header       = $this->createHeader();
		$this->body         = $this->createBody();
		$this->footer       = $this->createFooter();
		$this->form         = $this->createForm($tfa, $return);
		$this->socialLogins = $socialLogins ? $this->createSocialLogins() : NULL;
	}

	public function hasSocialLogins() {
		return $this->socialLogins != NULL;
	}

	protected function createHeader() {
		$rc = new Div($this);
		$rc->addClass('login-form-header');
		new SystemMessages($rc);
		return $rc;
	}

	protected function createFooter() {
		$rc = new Div($this);
		$rc->addClass('login-form-header');
		return $rc;
	}

	protected function createBody() {
		$container = new Div($this);
		$container->addClass('login-form-body');
		return $container;
	}

	protected function createForm($tfa, $return) {
		$form   = new VerticalForm($this->body, 'loginForm');
		$form->setMethod('POST');
		$this->createUserInput($form);
		$this->createPasswordInput($form);
		if ($tfa) $this->createTFAInput($form);
		$this->createPersistentCheck($form);
		$this->createReturnInput($form, $return);
		$this->createLoginButton($form);
		return $form;
	}

	protected function createUserInput($form) {
		$userid = $this->request->getPostParam('userid', '');
		$user   = new TextInput($form, 'userid', $userid);
		//$user->setLabel('login_email_label');
		$user->setPlaceholder('login_email_placeholder');
		return $user;
	}

	protected function createPasswordInput($form) {
		$pass = new PasswordInput($form, 'password');
		//$pass->setLabel('login_password_label');
		$pass->setPlaceholder('login_password_placeholder');
		return $pass;
	}

	protected function createTFAInput($form) {
		return NULL;
	}

	protected function createPersistentCheck($form) {
		return new HiddenInput($form, 'persist', '1');
	}

	protected function createReturnInput($form, $return) {
		if ($return == NULL) $return =  $this->request->getParam('return');
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
			return new HiddenInput($form, 'return', $return);
		}
		return NULL;
	}

	protected function createLoginButton($form) {
		$rc = new SubmitButton($form, 'button_login_label');
		$rc->setName('action');
		$rc->setValue('login');
		return $rc;
	}
	
	protected function createSocialLogins() {
		$rc = new Div($this);
		$rc->addClass('social-login')->addClass('card-body');
		$this->createFacebookLogin($rc);
		$this->createTwitterLogin($rc);
		$this->createGoogleLogin($rc);
		return $rc;
	}

	protected function createFacebookLogin($parent) {
		$rc = $this->createSocialButton($parent, 'facebook-login', '<i class="fab fa-lg fa-facebook"></i>', 'login_with_facebook_label');
		$rc->addClass('facebook-login');
		return $rc;
	}

	protected function createTwitterLogin($parent) {
		$rc = $this->createSocialButton($parent, 'twitter-login', '<i class="fab fa-lg fa-twitter"></i>', 'login_with_twitter_label');
		return $rc;
	}

	protected function createGoogleLogin($parent) {
		$rc = $this->createSocialButton($parent, 'google-login', '<img src="'.\WebApp\Utils::getImageBaseUrl(TRUE).'/google-login.png">', 'login_with_google_label');
		return $rc;
	}

	protected function createSocialButton($parent, $class, $icon, $label) {
		$content = '<span class="social-button-icon">'.$icon.'</span>'.
		           '<span class="social-button-label">'.\TgI18n\I18N::_($label).'</span>';
		$rc = new Button($parent, $content);
		$rc->addClass('social-button')->addClass($class);
		return $rc;
	}

	public function getHeader() {
		return $this->header;
	}

	public function getBody() {
		return $this->body;
	}

	public function getForm() {
		return $this->form;
	}

	public function getFooter() {
		return $this->footer;
	}

	public function getSocialLogins() {
		return $this->socialLogins;
	}

	public function addTitle($label = NULL) {
		if ($label == NULL) $label = 'login_title';
		return new Heading($this->header, 4, $label);
	}
	
}

