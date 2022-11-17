<?php

namespace WebApp\DataModel;

class UserRole {

	/** A pseudo role for non-registered users */
	public const ROLE_GUEST = 'guest';
	/** A pseudo role for all registered users */
	public const ROLE_USER = 'user';
	/** A defined role that can do everything */
	public const ROLE_SUPERADMIN = 'superadmin';

	public $privileges;

	public function __construct() {
	}

	public function getPrivileges() {
		$rc = array();
		if (is_string($this->privileges)) {
			$rc = explode(',', $this->privileges);
		}
		return $rc;
	}

	public function hasPrivilege($s) {
		return in_array($s, $this->getPrivileges());
	}

	public function addPrivilege($s) {
		if (!$this->hasPrivilege($s)) {
			$arr   = $this->getPrivileges();
			$arr[] = $s;
			$this->setPrivileges($arr);
		}
	}

	public function setPrivileges($arr) {
		if (is_string($arr)) $this->privileges = $arr;
		else if (is_array($arr)) $this->privileges = implode(',', $arr);
	}

	public function isActive() {
		return $this->is_active > 0;
	}
}
