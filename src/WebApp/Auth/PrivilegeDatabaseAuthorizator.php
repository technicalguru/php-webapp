<?php

namespace WebApp\Auth;

use WebApp\Application;
use WebApp\WebAppException;
use WebApp\DataModel\UserRole;
use WebApp\DataModel\UserRoleDAO;

/**
 * Checks the roles of a user (required method on principal is getRoles().
 */
class PrivilegeDatabaseAuthorizator extends AbstractAuthorizator {

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
		$this->dao = new UserRoleDAO($this->app->database, $modelClass);
		if ($this->app->dataModel) {
			$this->app->dataModel->register('userRoles', $this->dao);
		}
	}

	/**
	 * Authorizes a user.
	 * @param Principal $user - the user to be authorized.
	 * @param mixed     $required  - the required privilege.
	 * @return TRUE when principal was authorized
	 */
	public function authorize($user, $required) {
		// Least privilege: everyone
		if ($required == UserRole::ROLE_GUEST) return TRUE;

		// From here on we need a user object
		if ($user != NULL) {
			$roles = $user->getRoles();

			// Least privilege: any user
			if ($required == UserRole::ROLE_USER) return TRUE;

			// Superadmins are always authorized
			if (in_array(UserRole::ROLE_SUPERADMIN, $roles)) return TRUE;

			// Search the specific privilege
			// TODO find the roles in database, and check each for the required privilege
			throw new WebAppException('Privilege authorization is not yet supported');
		}
		return FALSE;
	}
}
