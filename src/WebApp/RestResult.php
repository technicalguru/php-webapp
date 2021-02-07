<?php

namespace WebApp;

class RestResult {

	public $success;

	public function __construct() {
	}

	public function setData($data) {
		$this->success = TRUE;
		$this->data    = $data;
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

	public static function error403() {
		$rc = new RestResult();
		$rc->setError(403, 'Forbidden');
		return $rc;
	}

	public static function error400() {
		$rc = new RestResult();
		$rc->setError(400, 'Invalid Request');
		return $rc;
	}

	public static function error404() {
		$rc = new RestResult();
		$rc->setError(404, 'Not Found');
		return $rc;
	}
}
