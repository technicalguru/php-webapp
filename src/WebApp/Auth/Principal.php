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
}
