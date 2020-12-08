<?php

namespace WebApp\Auth;

/** Basic interface for any form of authorization */
interface Authorizator {

	/**
	 * Authorizes a principal
	 * @param Principal $principal - the principal to be authorized.
	 * @param mixed     $required  - the required authorization information.
	 * @return TRUE when principal was authorized
	 */
	public function authorize($principal, $required);

}
