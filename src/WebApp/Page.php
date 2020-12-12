<?php

namespace WebApp;

use TgLog\Log;
use TgLog\Error;
use WebApp\Component\Alert;

class Page extends Component\Component {

	protected $app;
	protected $request;
	protected $display;

	public function __construct($app) {
		parent::__construct(NULL);
		$this->app     = $app;
		$this->request = \TgUtils\Request::getRequest();
		$this->display = 'public';
	}

	public function getTitle() {
		return 'hello_world_title';
	}

	public function getMain() {
		switch ($this->display) {
		case 'public':     return $this->getPublicMain();
		case 'authorized': return $this->getProtectedMain();
		case 'forbidden':  return $this->getForbiddenMain();
		}
		return $this->getPublicMain();
	}

	public function getPublicMain() {
		$rc = array(
			$this->getMessages(),
			new Component\Title($this, $this->getTitle()),
			new Component\Paragraph($this, 'hello_world'),
		);
		if ($this->display == 'login') {
			$form = $this->getLoginForm();
			if ($form != NULL) $rc[] = $form;
		}
		return $rc;
	}

	public function getProtectedMain() {
		return array(
			$this->getMessages(),
			new Component\Title($this, $this->getTitle()),
			new Component\Paragraph($this, 'hello_world'),
		);
	}

	public function getForbiddenMain() {
		$rc = array(
			$this->getMessages(),
			new Component\Title($this, 'access_forbidden_title'),
			new Component\Paragraph($this, 'access_forbidden_description'),
		);
		return $rc;
	}

	protected function getMessages() {
		$rc = array();
		$messages = Log::get();
		if (is_array($messages)) {
			foreach ($messages AS $message) {
				switch ($message->getType()) {
				case 'error':   $rc[] = new Alert($this, Alert::ERROR,   NULL, $message->getMessage()); break;
				case 'warning': $rc[] = new Alert($this, Alert::WARNING, NULL, $message->getMessage()); break;
				case 'info':    $rc[] = new Alert($this, Alert::INFO,    NULL, $message->getMessage()); break;
				case 'success': $rc[] = new Alert($this, Alert::SUCCESS, NULL, $message->getMessage()); break;
				}
			}
		}
		Log::clean();
		return $rc;
	}

	/** NULL will use the themes default layout */
	public function getLayoutName() {
		return NULL;
	}

	public function processRequest() {
		if ($this->request->getPostParam('action') == 'login') {
			$this->processLoginAction();
			return array('redirect', $this->request->path);
		} else if ($this->request->hasGetParam('logout')) {
			$this->processLogoutAction();
			$home = $this->app->getPageLink('home');
			if ($home == NULL) $home = $this->request->path;
			else $home = $this->app->router->getCanonicalPath($home);
			return array('redirect', $home);
		}

		$requiredRight = $this->getRequiredRight();
		if (($requiredRight != NULL) && ($requiredRight != 'guest')) {
			return $this->computeDisplayMode();
		}
		Log::debug('display='.$this->display);
		return 'render';
	}

	/**
	 * Process the login action.
	 */
	protected function processLoginAction() {
		$userid  = trim($this->request->getPostParam('userid', ''));
		$passwd  = trim($this->request->getPostParam('password', ''));
		$persist = $this->request->getPostParam('persist', FALSE);

		if ($userid && $passwd) {
			if (!$this->app->authenticate($userid, new Auth\SecretData($passwd), $persist)) {
				// Login failed
				Log::register(new Error('login_failed'));
			} else {
				// Return to uri if required
				$return = $this->request->getPostParam('return');
				if (($return != NULL) && (strlen($return) > 0)) {
					header('Location: '.$return);
					exit;
				}
				// Is there a standard login landing page?
			}
		} else {
			// Set error
			if (!$userid) Log::register(new Error('login_userid_missing'));
			if (!$passwd) Log::register(new Error('login_password_missing'));
		}
	}

	/**
	 * Process the logout action.
	 */
	protected function processLogoutAction() {
		$this->app->setPrincipal(NULL);
	}

	/**
	 * Computes how to display this page (public, protected, login, redirection, forbidden)
	 */
	protected function computeDisplayMode() {
		if ($this->app->getPrincipal() == NULL) {
			// We need a login
			$this->display = 'login';
			$uri           = $this->app->getPageLink('login');
			if ($uri != NULL) {
				$uri = $this->app->router->getCanonicalPath($uri);
				if ($uri != $this->request->path) {
					return array('redirect', $uri.'?return='.urlencode($this->request->uri));
				}
			}
		} else if ($this->app->isAuthorized($requiredRight)) {
			// We can render
			$this->display = 'authorized';
		} else {
			// User is not authorized
			$this->display = 'forbidden';
		}
		return 'render';
	}

	/**
	 * Returns required role or permission (depending on authorization handler) for this
	 * page to display.
	 * @return string the required right (permission or role or ...)
	 */
	protected function getRequiredRight() {
		return NULL;
	}

	protected function getLoginForm() {
		$rc = array(
			new Component\Paragraph($this, 'please_login'),
		);
		$form   = new Component\Form($this, 'loginForm', Component\Form::HORIZONTAL);
		$form->setMethod('POST');
		$form->setAction($this->request->path);

		$userid = $this->request->getPostParam('userid', '');
		$user   = new Component\TextInput($form, 'userid', $uid);
		$user->setLabel('login_userid_label');
		$user->setPlaceholder('login_userid_placeholder');
		$user->setHelp('login_userid_help');

		$pass   = new Component\PasswordInput($form, 'password');
		$pass->setLabel('login_password_label');
		$pass->setPlaceholder('login_password_placeholder');
		$pass->setHelp('login_password_help');

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
			new Component\HiddenInput($form, 'return', $return);
		}

		$group  = new Component\ButtonGroup($form);
		$submit = new Component\Button($group, 'button_login_label');
		$submit->setType('submit');
		$submit->setName('action');
		$submit->setValue('login');

		$rc[] = $form;
		return $rc;
	}

	public function getJavascript() {
		return array();
	}

}

