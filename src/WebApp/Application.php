<?php

namespace WebApp;

use TgUtils\Request;
use TgUtils\Date;
use TgLog\Log;
use TgI18n\I18N;

class Application {

	public    $config;
	public    $request;
	public    $vault;
	public    $database;
	public    $dataModel;
	public    $authentication;
	public    $authorization;
	public    $sessionHandler;
	public    $router;
	public    $mailQueue;
	public    $theme;
	protected $principal;

	public function __construct($config) {
		$this->config    = $config;
		$this->request   = $this->initRequest();
		$this->principal = NULL;
		I18N::addI18nFile(__DIR__.'/../i18n.php');
	}

	protected function initRequest() {
		$request    = Request::getRequest();
		$request->setAppRoot(WFW_ROOT_DIR);
		return $request;
	}

	public function init() {
		$this->initVault();
		$this->initDatabase();
		$this->initDataModel();
		$this->initAuthentication();
		$this->initAuthorization();
		$this->initSession();
		$this->initRouter();
		$this->initMailQueue();
		$this->initMaintenance();
	}

	protected function initVault() {
		if ($this->config->has('vault')) {
			$this->vault = \TgVault\VaultFactory::create($this->config->get('vault'));
			// TODO $this->vault->setLogger(Log::instance());
		}
	}

	protected function initDatabase() {
		if ($this->config->has('database')) {
			// Allow vault intervention
			$credentials    = $this->config->getCredentialsProvider('database', $this->vault);
			$this->database = new \TgDatabase\Database($this->config->get('database', TRUE), $credentials);
			if ($this->database->hasError()) {
				throw new WebAppException('Cannot connect to database: '.$this->database->error());
			}
		}
	}

	protected function initDataModel() {
		if ($this->database && $this->config->has('dataModel') && $this->config->get('dataModel')) {
			$this->dataModel = new \TgDatabase\DataModel($this->database);
			$this->dataModel->register('log', new DataModel\LogDAO($this->database));
		}
	}

	protected function initAuthentication() {
		if ($this->config->has('authentication')) {
			$authConfig = $this->config->get('authentication'); 
			$className  = NULL;
			$config     = NULL;
			if (is_object($authConfig)) {
				$className = $authConfig->class;
				if (isset($authConfig->config)) $config = $authConfig->config;
			} else if (is_array($authConfig)) {
				$className = $authConfig['class'];
				if (isset($authConfig['config'])) $config = $authConfig['config'];
			} else {
				$className = $authConfig;
			}
			if (substr($className, 0, 1) != '\\') $classname = '\\'.$className;
			if (class_exists($className)) {
				$this->authentication = new $className($this, $config);
			} else {
				throw new WebAppException('Cannot find Authentication class: '.$className);
			}
		}
	}

	protected function initAuthorization() {
		if ($this->config->has('authorization')) {
			$authConfig = $this->config->get('authorization'); 
			$className  = NULL;
			$config     = NULL;
			if (is_object($authConfig)) {
				$className = $authConfig->class;
				if (isset($authConfig->config)) $config = $authConfig->config;
			} else if (is_array($authConfig)) {
				$className = $authConfig['class'];
				if (isset($authConfig['config'])) $config = $authConfig['config'];
			} else {
				$className = $authConfig;
			}
			if (substr($className, 0, 1) != '\\') $classname = '\\'.$className;
			if (class_exists($className)) {
				$this->authorization = new $className($this, $config);
			} else {
				throw new WebAppException('Cannot find Authorization class: '.$className);
			}
		}
	}

	protected function getSessionCookieName() {
		return preg_replace( '/[\W]/', '', 'WebApp'.$this->request->webRoot);
	}

	protected function initSession() {
		$cookieName = $this->getSessionCookieName();
		if ($this->database) {
			if ($this->dataModel) {
				$this->sessionHandler = Session\Utils::create($cookieName, $this->dataModel);
			} else {
				$this->sessionHandler = Session\Utils::create($cookieName, $this->database);
			}
		} else {
			$this->sessionHandler = Session\Utils::create($cookieName);
		}
	}

	protected function initRouter() {
		if ($this->config->has('router')) {
			$routerConf  = $this->config->get('router');
			$config      = isset($routerConf->config) ? $routerConf->config : array();
			$routerClass = isset($routerConf->class)  ? $routerConf->class  : 'WebApp\\Router';
			if (substr($routerClass, 0, 1) != '\\') $routerClass = '\\'.$routerClass;
			if (class_exists($routerClass)) {
				$this->router = new $routerClass($this, $config);
			} else {
				$this->router = new Router($this, $config);
			}
		} else {
			$this->router = new Router($this);
		}
	}

	/** A router can use this method to check whether we are in maintenance */
	public function isMaintenance() {
		return $this->config->has('maintenance') && $this->config->get('maintenance');
	}

	/** Init parameters for maintenance */
	public function initMaintenance() {
		$this->maintenanceMode = $this->isMaintenance();
		// Set a maintenance user if available and no other user online
		if ($this->maintenanceMode && !isset($this->maintenanceUser)) {
			$this->maintenanceUser = $this->getMaintenanceUser();
			if ($this->maintenanceUser != NULL) {
				$this->principal       = $this->maintenanceUser;
			}
		}
	}

	/**
	 * Override if you need access with a specific user in maintenance mode
	 * The function is called only when maintenance mode is on
	 * Attention! You will need a security protection to not allow others to
	 * use this user in maintenance mode
	 */
	protected function getMaintenanceUser() {
		return NULL;
	}

	protected function initMailQueue() {
		if ($this->config->has('mailQueue')) {
			$mailDAO = NULL;
			if ($this->database) {
				$mailDAO = new \TgEmail\EmailsDAO($this->database);
				if ($this->dataModel != NULL) {
					$this->dataModel->register('emails', $mailDAO);
				}
			}
			$mailConfig          = \TgEmail\EmailConfig::from($this->config->get('mailQueue'));
			$credentialsProvider = $this->config->getCredentialsProvider('mailQueue', $this->vault);
			if ($credentialsProvider != NULL) {
				$mailConfig->getSmtpConfig()->setCredentialsProvider($credentialsProvider);
			}
			$this->mailQueue     = new \TgEmail\EmailQueue($mailConfig, $mailDAO);
		}
	}

	public function getTheme() {
		return $this->config->get('theme');
	}

	public function getName() {
		return $this->config->get('name');
	}

	public function getBrandName() {
		if ($this->config->has('brandName')) {
			return $this->config->get('brandName');
		}
		return $this->config->get('name');
	}

	public function getBrandLink() {
		return $this->config->get('brandLink');
	}

	public function getBrandLogo() {
		return $this->config->get('brandLogo');
	}

	public function getBrandSize() {
		return $this->config->get('brandSize');
	}

	public function getLogo($size = 'lg') {
		if ($this->config->has('logo')) {
			return $this->config->get('logo')->$size;
		}
		return NULL;
	}

	public function getCopyright() {
		return $this->config->get('copyright');
	}

	public function getCssFiles() {
		if ($this->config->has('css')) {
			return $this->config->get('css');
		}
		return array();
	}

	public function getPrincipal() {
		// Retrieve from session
		if (($this->principal == NULL) && isset($_SESSION['principal'])) {
			$this->principal = $this->authentication->get($_SESSION['principal']);
		}
		return $this->principal;
	}

	public function setPrincipal($principal, $persist = FALSE) {
		$this->principal = $principal;
		if ($principal != NULL) {
			$_SESSION['principal'] = $principal->getId();
			if (method_exists($this->sessionHandler, 'setPersistent')) {
				$this->sessionHandler->setPersistent($persist);
			}
		} else {
			unset($_SESSION['principal']);
			if (method_exists($this->sessionHandler, 'setPersistent')) {
				$this->sessionHandler->setPersistent(FALSE);
			}
		}
	}

	public function authenticate($id, $secret, $persist = FALSE) {
		if ($this->authentication != NULL) {
			$result = $this->authentication->authenticate($id, $secret);
			if (!is_a($result, 'WebApp\\Auth\\AuthError')) {
				$this->setPrincipal($result, $persist);
				$this->sessionHandler->gc(3600);
				$this->executeHook('authenticated');
			}
			return $result;
		}
		return FALSE;
	}

	/** You can listen to some special events such as login or logout
	  * Hook names:
	  *   authenticated - user was successfully logged in
	  */
	public function executeHook($hookName) {
		// Does nothing
	}

	/** Return whether the current user has the required permissions */
	public function isAuthorized($required) {
		if ($this->authorization != NULL) {
			return $this->authorization->authorize($this->getPrincipal(), $required);
		}
		return TRUE;
	}

	public function getMetaKeywords() {
		return NULL;
	}

	/** Return footer if required */
	public function getFooter() {
		return NULL;
	}

	/** Returns array of javascript snippets (script tags!) */
	public function getJavascript() {
		return array();
	}

	/**
	 * Returns special defined page links or URIs for usage in various
	 * contexts. Mostly used is 'login', 'logout', 'forget_password', 'home'.
	 * @param string $key - key of the link
	 * @return the page link, URI or NULL.
	 */
	public function getPageLink($key) {
		if ($this->config->has('pageLinks')) {
			$links = $this->config->get('pageLinks');
			if (isset($links->$key)) return $links->$key;
		}
		return NULL;
	}

	/**
	 * returns an array of menu items.
	 * @param string $id - denotes the ID of the menu to return, depends on the chosen layout. NULL usually means the main menu.
	 *                     Bootstrap layouts will ask for the 'user' menu which can return profile page, change password page and others.
	 */
	public function getMenu($id = NULL) {
		return NULL;
	}

	public function getErrorPage($httpCode, $text, $throwable = NULL) {
		return NULL;
	}

	/**
	 * Persist any error message in the database.
	 */
	public function afterRequest() {
		// Persist the Log when configured
		if ($this->config->has('logErrors') && $this->config->get('logErrors') && $this->dataModel) {
			$messages = Log::instance()->messages;
			if (isset($messages['error']) && (count($messages['error']) > 0)) {
				$log           = new DataModel\Log();
				$log->log_text = $messages;
				$log->log_date = Date::getInstance(time(), WFW_TIMEZONE);
				$this->dataModel->get('log')->create($log);
			}
		}
	}

	public function dao($name) {
		if ($this->dataModel != NULL) {
			return $this->dataModel->get($name);
		}
		return NULL;
	}
}

