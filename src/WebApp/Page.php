<?php

namespace WebApp;

use TgLog\Log;
use TgLog\Error;
use WebApp\Component\Alert;

class Page extends Component\Component {

	protected $app;
	protected $request;
	protected $display;
	protected $annotations;

	public function __construct($app) {
		parent::__construct(NULL);
		$this->app         = $app;
		$this->request     = \TgUtils\Request::getRequest();
		$this->display     = 'public';
		$this->annotations = array();
		$i18n = $this->getTranslations();
		if (($i18n != NULL) && is_array($i18n) && (count($i18n)>0)) {
			\TgI18n\I18N::addValues($i18n);
		}
	}

	public function getAnnotations() {
		return $this->annotations;
	}

	public function getAnnotation($key, $default = NULL) {
		return isset($this->annotations[$key]) ? $this->annotations[$key] : $default;
	}

	public function setAnnotation($key, $value) {
		$this->annotations[$key] = $value;
		return $this;
	}

	public function getTranslations() {
		return array();
	}

	public function getTitle() {
		return 'hello_world_title';
	}

	public function getMeta() {
		$rc = array();
		$s = $this->getMetaKeywords();
		if ($s != NULL) $rc['keywords'] = $s;
		$s = $this->getMetaDescription();
		if ($s != NULL) $rc['description'] = $s;
		return $rc;
	}

	public function getOtherHeaders() {
		return array();
	}

	public function getMetaKeywords() {
		return $this->app->getMetaKeywords();
	}

	public function getMetaDescription() {
		return NULL;
	}

	public function getBreadcrumbs() {
		return array();
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
		return new Component\SystemMessages($this);
	}

	/** NULL will use the themes default layout */
	public function getLayoutName() {
		return NULL;
	}

	public function processRequest() {
		if ($this->request->getPostParam('action') == 'login') {
			if ($this->processLoginAction()) {
				return array('redirect', $this->request->path);
			}
		} else if ($this->request->hasGetParam('logout')) {
			$this->processLogoutAction();
			if ($this->getRequiredRight() != DataModel\UserRole::ROLE_GUEST) {
				$home = $this->app->getPageLink('home');
				if ($home == NULL) $home = $this->request->originalPath;
				else $home = $this->app->router->getCanonicalPath($home);
				return array('redirect', $home);
			}
		}

		return $this->processAuthorization();
	}

	protected function processAuthorization() {
		$requiredRight = $this->getRequiredRight();
		if (($requiredRight != NULL) && ($requiredRight != 'guest')) {
			$rc = $this->computeDisplayMode();
			Log::debug('display='.$this->display);
			return $rc;
		}
		return 'render';
	}

	/**
	 * Process the login action.
	 * Returns TRUE when login succeeded.
	 */
	protected function processLoginAction() {
		$userid  = trim($this->request->getPostParam('userid', ''));
		$passwd  = trim($this->request->getPostParam('password', ''));
		$persist = $this->request->getPostParam('persist', FALSE);
		$rc      = FALSE;

		if ($userid && $passwd) {
			$result = $this->app->authenticate($userid, new Auth\SecretData($passwd), $persist);
			if ($result === FALSE) {
				// Login failed
				Log::register(new Error('login_failed'));
				Log::error('Authentication not configured');
			} else if (is_a($result, 'WebApp\\Auth\\AuthError')) {
				// Login failed
				Log::register(new Error($result->getMessage()));
				Log::error('Authentication error: '.$result->errorCode);
			} else {
				// Return to uri if required
				$return = $this->request->getPostParam('return');
				Session\Utils::setFreshLogin();
				if (($return != NULL) && (strlen($return) > 0)) {
					header('Location: '.$return);
					exit;
				}
				// Is there a standard login landing page?
				$rc = TRUE;
			}
		} else {
			// Set error
			if (!$userid) Log::register(new Error('login_userid_missing'));
			if (!$passwd) Log::register(new Error('login_password_missing'));
		}
		return $rc;
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
		$principal = $this->app->getPrincipal();
		if ($principal == NULL) {
			// We need a login
			$this->display = 'login';
			$uri           = $this->app->getPageLink('login');
			if ($uri != NULL) {
				$uri = $this->app->router->getCanonicalPath($uri);
				if ($uri != $this->request->path) {
					return array('redirect', $uri.'?return='.urlencode($this->request->uri));
				}
			}
		} else if ($this->app->isAuthorized($this->getRequiredRight())) {
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

		$pass   = new Component\PasswordInput($form, 'password');
		$pass->setLabel('login_password_label');
		$pass->setPlaceholder('login_password_placeholder');

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

	protected function dao($name) {
		return $this->app->dao($name);
	}

	protected function svc($name) {
		return $this->app->svc($name);
	}

	/** Overwrite when u dont want to have this page appear in access log */
	public function isInAccessLog() {
		return TRUE;
	}
}

