<?php

namespace WebApp\Auth;

use WebApp\Application;

/**
 * Abstract implementation that can be used for multiple purposes.
 */
abstract class AbstractAuthenticator implements Authenticator {

	protected $app;

	public function __construct(Application $app) {
		$this->app = $app;
		$this->init();
	}

	/** Initialize this object */
	protected function init() {
	}

}
