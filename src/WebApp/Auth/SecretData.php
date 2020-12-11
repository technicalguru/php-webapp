<?php

namespace WebApp\Auth;

/**
 * A helper object to encapsulate the authentication data.
 */
class SecretData {

	public $password;
	public $token;
	public $tokenType;

	/** Constructor */
	public function __construct($password, $token = NULL, $tokenType = NULL) {
		$this->password  = $password;
		$this->token     = $token;
		$this->tokenType = $tokenType;
	}

}
