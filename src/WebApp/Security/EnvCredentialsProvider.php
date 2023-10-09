<?php

namespace WebApp\Security;

/**
  * A Helper class that gets its credentials from environment variables.
  */
class EnvCredentialsProvider extends \TgUtils\Auth\DefaultCredentialsProvider {

	/**
	  * Construct the provider.
	  * @param string $usernameKey - the name of the environment variable holding the username (default is 'USERNAME')
	  * @param string $passwordKey - the name of the environment variable holding the password (default is 'PASSWORD')
	  */
	public function __construct($usernameKey = NULL, $passwordKey = NULL) {
		if (($usernameKey == NULL) || (trim($usernameKey) == '')) $usernameKey = 'USERNAME';
		if (($passwordKey == NULL) || (trim($passwordKey) == '')) $passwordKey = 'PASSWORD';
		parent::__construct($_ENV[$usernameKey], $_ENV[$passwordKey]);
	}

}

