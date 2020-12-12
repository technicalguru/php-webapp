<?php

namespace WebApp;

define ('WEBAPP_SUB_PATH', '/vendor/technicalguru/webapp');

use TgUtils\Request;

class Utils {

	public static function getWebRootUrl($webapp = FALSE) {
		$request = Request::getRequest();
		return $request->webRootUri.$request->relativeAppPath.($webapp ? WEBAPP_SUB_PATH : '');
	}

	public static function getWebRootPath($webapp = FALSE) {
		$request = Request::getRequest();
		return $request->webRoot.$request->relativeAppPath.($webapp ? WEBAPP_SUB_PATH : '');
	}

	public static function getJavascriptBaseUrl($webapp = FALSE) {
		return self::getWebRootUrl($webapp).'/js';
	}

	public static function getJavascriptBasePath($webapp = FALSE) {
		return self::getWebRootPath($webapp).'/js';
	}

	public static function getImageBaseUrl($webapp = FALSE) {
		return self::getWebRootUrl($webapp).'/images';
	}

	public static function getImageBasePath($webapp = FALSE) {
		return self::getWebRootPath($webapp).'/images';
	}

	public static function getCssBaseUrl($webapp = FALSE) {
		return self::getWebRootUrl($webapp).'/css';
	}

	public static function getCssBasePath($webapp = FALSE) {
		return self::getWebRootPath($webapp).'/css';
	}

	public function getFontBaseUrl($webapp = FALSE) {
		return self::getWebRootUrl($webapp).'/fonts';
	}

	public function getFontBasePath($webapp = FALSE) {
		return self::getWebRootPath($webapp).'/fonts';
	}
}

