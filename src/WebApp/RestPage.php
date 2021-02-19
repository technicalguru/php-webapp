<?php

namespace WebApp;

use TgLog\Log;
use TgLog\Error;
use WebApp\Component\Alert;

class RestPage extends Page {

	public function __construct($app) {
		parent::__construct($app);
	}

	public function getLayoutName() {
		return 'WebApp\\DefaultTheme\\RestLayout';
	}

	public function getMain() {
		return $this->result;
	}

	public function processRequest() {
		try {
			if ($this->app->isAuthorized($this->getRequiredRight())) {
				// We can render
				switch ($this->request->method) {
				case 'HEAD':
					$this->result = $this->head();
					break;
				case 'GET':
					$this->result = $this->get();
					break;
				case 'POST':
					$this->result = $this->post();
					break;
				case 'PUT':
					$this->result = $this->put();
					break;
				case 'PATCH':
					$this->result = $this->patch();
					break;
				case 'DELETE':
					$this->result = $this->delete();
					break;
				}
			} else {
				$this->result = RestResult::error403();
			}
		} catch (\Throwable $t) {
			$data = NULL;
			if ($this->app->config->has('debug') && $this->app->config->get('debug')) {
				$data = \TgUtils\FormatUtils::getTraceLines($t);
			}
			$this->result = RestResult::error500($data);
		}
		return 'render';
	}

	protected function head() {
		return RestResult::error404();
	}

	protected function get() {
		return RestResult::error404();
	}

	protected function put() {
		return RestResult::error404();
	}

	protected function post() {
		return RestResult::error404();
	}

	protected function patch() {
		return RestResult::error404();
	}

	protected function delete() {
		return RestResult::error404();
	}

	protected function getJsonBody() {
		if (!isset($this->jsonBody)) {
			$body = $this->request->getBody();
			if (!\TgUtils\Utils::isEmpty($body)) {
				$this->jsonBody = json_decode($body);
			} else {
				$this->jsonBody = new \stdClass;
			}
		}
		return $this->jsonBody;
	}

	protected function getJsonParam($key, $default = NULL) {
		$obj = $this->getJsonBody();
		if (!isset($obj->$key)) return $default;
		return $obj->$key;
	}
}

