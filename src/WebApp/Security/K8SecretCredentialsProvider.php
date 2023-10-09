<?php

namespace WebApp\Security;

/**
  * A Helper class that returns the credentials from a Secret mounted in a Kubernetes pod.
  */
class K8SecretCredentialsProvider extends \TgUtils\Auth\DefaultCredentialsProvider {

	/** The path where the secret is stored */
	private $path;
	/** The key in the secret holding the username (default is 'username') */
	private $usernameKey;
	/** The key in the secret holding the password (default is 'password') */
	private $passwordKey;

	/**
	 * Construct the provider.
	 * @param string $path        - the path to the mounted Kubernets secret
	 * @param string $usernameKey - the key in the secret holding the username (default is 'username')
	 * @param string $passwordKey - the key in the secret holding the password (default is 'password')
	 */
	public function __construct($path, $usernameKey = NULL, $passwordKey = NULL) {
		if (($usernameKey == NULL) || (trim($usernameKey) == '')) $usernameKey = 'username';
		if (($passwordKey == NULL) || (trim($passwordKey) == '')) $passwordKey = 'password';
		$this->path        = $path;
		$this->usernameKey = $usernameKey;
		$this->passwordKey = $passwordKey;
		parent::__construct('', '');
	}

	public function getUsername() {
		return $this->get($this->usernameKey);
	}

	public function getPassword() {
		return $this->get($this->passwordKey);
	}

	public function get($key) {
		if (file_exists($this->path.'/'.$key)) {
			return trim(file_get_contents($this->path.'/'.$key));
		}
		return NULL;
	}
}

