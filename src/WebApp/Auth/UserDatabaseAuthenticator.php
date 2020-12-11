<?php

namespace WebApp\Auth;

use WebApp\Application;
use WebApp\WebAppException;
use WebApp\DataModel\User;
use WebApp\DataModel\UserDAO;

/**
 * An authenticator for the standard UserDAO database storage (email+password).
 */
class UserDatabaseAuthenticator extends AbstractAuthenticator {

	public function __construct(Application $app) {
		parent::__construct($app);
	}

	protected function init() {
		parent::init();
		if (!$this->app->database) {
			throw new WebAppException('A database connection is required.');
		}
		$this->dao = new UserDAO($this->app->database);
		if ($this->app->dataModel) {
			$this->app->dataModel->register('users', $this->dao);
		}
	}

	/**
	 * Authenticates a user with given password.
	 * @param $id  - E-Mail of user to authenticate.
	 * @param SecretData - the secrets required to authenticate (password only).
	 * @return Principal - The principal that was authenticated or NULL when authentication failed.
	 */
	public function authenticate($id, SecretData $secretData) {
		$user = $this->dao->getByEmail($id);
		if ($user != NULL) {
			if (!($user->isBlocked())) {
				if (!($user->verifyPassword($secretData->password))) {
					$user->registerFailedLoginAttempt();
					$this->dao->save($user);
					$user = NULL;
				} else {
					$user->registerSuccessfulLogin();
					$this->dao->save($user);
				}
			} else {
				$user = NULL;
			}
		}
		return $user;
	}

	/**
	 * Returns the user with given UID.
	 * <p>This method is required to get the authenticated principal across multiple session calls.</p>
	 * @param mixed $id - the UID of the user.
	 * @return Principal the user
	 */
	public function get($id) {
		$user = $this->dao->get($id);
		if ($user->status != User::STATUS_ACTIVE) return NULL;
		return $user;
	}
}

