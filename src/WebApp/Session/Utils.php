<?php

namespace WebApp\Session;

use WebApp\DataModel\SessionDAO;

class Utils {

	/**
	 * Creates the correct session handler and returns it.
	 * @param string $appName - name of Cookie to be used
	 * @param object $persistence - database, DAO or DataModel object to be be used.
	 * @return \SessionHandler the session handler
	 */
	public static function create($appName, $persistence = NULL) {
		$rc = NULL;
		if ($persistence == NULL) {
			$rc = new DefaultSessionHandler();
		} else if (is_a($persistence, 'TgDatabase\\Database')) {
			$rc  = new DatabaseSessionHandler(new SessionDAO($persistence));
		} else if (is_a($persistence, 'TgDatabase\\DAO')) {
			$rc  = new DatabaseSessionHandler($persistence);
		} else if (is_a($persistence, 'TgDatabase\\DataModel')) {
			$dao = $persistence->get('sessions');
			if ($dao == NULL) {
				$dao = new SessionDAO($persistence->getDatabase());
				$persistence->register('sessions', $dao);
			}
			$rc  = new DatabaseSessionHandler($dao);
		} else {
			$rc = new DefaultSessionHandler();
		}

		session_set_save_handler($rc);
		ini_set('session.gc_maxlifetime', 3600);
		session_set_cookie_params(0);
		session_name($appName);
		session_start(['cookie_lifetime' => 365*\TgUtils\Date::SECONDS_PER_DAY]);

		return $rc;
	}

}
