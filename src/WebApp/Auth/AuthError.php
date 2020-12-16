<?php

namespace WebApp\Auth;

class AuthError {

	public const USER_NOT_FOUND           = 1;
	public const USER_BLOCKED             = 2;
	public const USER_TEMPORARILY_BLOCKED = 3;
	public const PASSWORD_INVALID         = 4;

	public $errorCode;
	public $errorMessage;

	public function __construct($errorCode, $errorMessage) {
		$this->errorCode    = $errorCode;
		$this->errorMessage = $errorMessage;
	}

	public function getMessage() {
		return \TgI18n\I18N::_($this->errorMessage);
	}
}

