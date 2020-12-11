<?php

namespace WebApp\Auth;

/**
 * An interface for a principal.
 */
interface Principal {

	/**
	 * Returns the unique ID of this principal.
	 * <p>Usually required for storage across a session</p>
	 * @return mixed - an ID.
	 */
	public function getId();

	/**
	 * Checks whether principal is allowed to login.
	 */
	public function isBlocked();

	/**
	 * Registers a failed attempt to login and blocks the principal if required.
	 * @return bool TRUE when the principal is now blocked temporarily because he exceeded a limit.
	 */
	public function registerFailedLoginAttempt();

	/**
	 * Registers a successful login. This can be used to reset any blocking attributes.
	 */
	public function registerSuccessfulLogin();
}
