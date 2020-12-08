<?php

namespace WebApp\Auth;

/** Basic interface for any form of authentication */
interface Authenticator {

	/**
	 * Authenticates with given data.
	 * @param mixed $id  - any unique ID of the principal.
	 * @param SecretData - the secrets required to authenticate.
	 * @return Principal - The principal that was authenticated or NULL when authentication failed.
	 */
	public function authenticate($id, SecretData $secretData);

	/**
	 * Returns the principal object with given ID.
	 * <p>This method is required to get the authenticated principal across multiple session calls.</p>
	 * @param mixed $id - the same ID that is returned by a Principal::getId() method.
	 * @return Principal the principal
	 */
	public function get($id);
}
