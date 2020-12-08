<?php

namespace WebApp\DataModel;

class User implements \WebApp\Auth\Principal {

	public const STATUS_REGISTERD = 'registered';
	public const STATUS_CONFIRMED = 'confirmed';
	public const STATUS_ACTIVE    = 'active';
	public const STATUS_DISABLED  = 'disabled';
	public const STATUS_DELETED   = 'deleted';

	public function __construct() {
	}

	/**
	 * Principal method.
	 */
	public function getId() {
		return $this->uid;
	}

	public function verifyPassword($password) {
		if (substr($this->password, 0, 1) != '$') {
			$this->setPassword($this->password);
		}
		return password_verify($password, $this->password);
	}

	public function setPassword($password) {
		$this->password = password_hash($password);
	}

	public function getRoles() {
		$rc = array();
		if (is_string($this->roles)) {
			$rc = explode(',', $this->roles);
		}
		return $rc;
	}

	public function hasRole($s) {
		return in_array($s, $this->getRoles());
	}

	public function addRole($s) {
		if (!$this->hasRole($s)) {
			$arr   = $this->getRoles();
			$arr[] = $s;
			$this->setRoles($arr);
		}
	}

	public function setRoles($arr) {
		if (is_string($arr)) $this->roles = $arr;
		else if (is_array($arr)) $this->roles = implode(',', $arr);
	}

	public function isActive() {
		return $this->status == User::STATUS_ACTIVE;
	}

	public function getData() {
		if (($this->data != NULL) && (substr($this->data, 0, 1) == '{')) return json_decode($this->data);
		return new \stdClass;
	}

	public function __toString() {
		return $this->name;
	}
}
