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

	public function __construct(Application $app, $config = NULL) {
		parent::__construct($app, $config);
	}

	protected function init() {
		parent::init();
		if (!$this->app->database) {
			throw new WebAppException('A database connection is required.');
		}
		$modelClass = NULL;
		if (($this->config != NULL) && isset($this->config['modelClass'])) {
			$modelClass = $this->config['modelClass'];
		}
		$this->dao = new UserDAO($this->app->database, $modelClass);
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
					return new AuthError(AuthError::PASSWORD_INVALID, 'user_password_invalid');
				} else {
					$user->registerSuccessfulLogin();
					$this->dao->save($user);
					return $user;
				}
			} else if ($user->isPermanentlyBlocked()) {
				return new AuthError(AuthError::USER_BLOCKED, 'user_blocked');
			}
			return new AuthError(AuthError::USER_TEMPORARILY_BLOCKED, 'user_temporarily_blocked');
		}
		return new AuthError(AuthError::USER_NOT_FOUND, 'user_not_found');
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

