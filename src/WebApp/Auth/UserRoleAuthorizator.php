<?php

namespace WebApp\Auth;

use \WebApp\Application;
use \WebApp\DataModel\UserRole;

/**
 * Checks the roles of a user (required method on principal is getRoles().
 */
class UserRoleAuthorizator extends AbstractAuthorizator {

	public function __construct(Application $app) {
		parent::__construct($app);
	}

	protected function init() {
		parent::init();
	}

	/**
	 * Authorizes a user.
	 * @param Principal $user - the user to be authorized.
	 * @param mixed     $required  - the required role.
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

			// Search the specific role
			return in_array($required, $roles);
		}
		return FALSE;
	}
}
