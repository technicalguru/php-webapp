<?php

namespace WebApp\Auth;

use WebApp\Application;

/**
 * Abstract implementation that can be used for multiple purposes.
 */
abstract class AbstractAuthenticator implements Authenticator {

	protected $app;
	protected $config;

	public function __construct(Application $app, $config = NULL) {
		$this->app    = $app;
		if (is_object($config)) $config = get_object_vars($config);
		$this->config = $config;
		$this->init();
	}

	/** Initialize this object */
	protected function init() {
	}

}
