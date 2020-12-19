<?php

namespace WebApp\Auth;

use \WebApp\Application;
use \WebApp\DataModel\UserRole;

/**
 * Checks the roles of a user (required method on principal is getRoles().
 */
class UserRoleAuthorizator extends AbstractAuthorizator {

	public function __construct(Application $app, $config = NULL) {
		parent::__construct($app, $config);
		if (isset($this->config['roles'])) {
			$this->roles = json_decode(json_encode($this->config['roles']), TRUE);
		} else {
			$this->roles = array();
		}
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
			return $this->isGranted($required, $roles);
		}
		return FALSE;
	}

	protected function isGranted($required, $granted) {
		$grantedExploded = $this->explodeRoles($granted);
		return in_array($required, $grantedExploded);
	}

	/** List all roles that are explicitely and implicitely part of the given roles */
	protected function explodeRoles($roles) {
		$rc = array();
		foreach ($roles AS $role) {
			// The granted role itself of course
			if (!in_array($role, $rc)) $rc[] = $role;
			// And all its children
			foreach ($this->getRoleChildren($role) AS $child) {
				if (!in_array($child, $rc)) $rc[] = $child;
			}
		}
		return $rc;
	}

	protected function getRoleChildren($role) {
		// Search the tree;
		$tree = $this->getRoleTree($role, $this->roles);
		// Not found => No children
		if ($tree == NULL) return array();
		// Flatten the hierarchy
		return $this->collectSubRoles($tree);
	}

	/** Can return NULL when needle not found. Otherwise returns the array with children. */
	protected function getRoleTree($needle, $treeNode) {
		foreach ($treeNode AS $key => $value) {
			if (is_int($key) && ($value == $needle)) {
				// simple role name, no children
				return array();
			} else if (is_string($key)) {
				if ($key == $needle) return $value;
				else {
					$found = $this->getRoleTree($needle, $value);
					if ($found != NULL) return $found;
				}
			}
		}
		return NULL;
	}

	/** Takes the tree and returns all defined roles in there */
	protected function collectSubRoles($node) {
		$rc = array();
		foreach ($node AS $key => $value) {
			if (is_int($key)) $rc[] = $value;
			else {
				$rc[] = $key;
				$rc   = array_merge($rc, $this->collectSubRoles($value));
			}
		}
		return $rc;
	}
}
