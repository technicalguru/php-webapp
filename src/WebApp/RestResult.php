<?php

namespace WebApp;

class RestResult {

	public $success;
	public $meta;

	public function __construct() {
	}

	public function setData($data) {
		$this->success = TRUE;
		$this->data    = $data;
	}

	public function setMeta($meta) {
		$this->meta = $meta;
	}

	public function setError($errorCode, $errorMessage = NULL, $errorData = NULL) {
		$this->success   = FALSE;
		$this->errorCode = $errorCode;
		if ($errorMessage != NULL) $this->errorMessage = $errorMessage;
		if ($errorData    != NULL) $this->errorData    = $errorData;
	}

	public static function success($data = NULL) {
		$rc = new RestResult();
		$rc->setData($data);
		return $rc;
	}

	public static function error($errorCode, $errorMessage, $data = NULL) {
		$rc = new RestResult();
		$rc->setError($errorCode, $errorMessage, $data);
		return $rc;
	}

	public static function error400($data = NULL) {
		return self::error(400, 'Invalid Request', $data);
	}

	public static function error403($data = NULL) {
		return self::error(403, 'Forbidden', $data);
	}

	public static function error404($data = NULL) {
		return self::error(404, 'Not Found', $data);
	}

	public static function error500($data = NULL) {
		return self::error(500, 'Internal Error', $data);
	}
}
