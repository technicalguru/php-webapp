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

	public static function getJavascriptUrl($filename, $webapp = FALSE) {
		$rc    = self::getJavascriptBaseUrl($webapp).'/'.$filename;
		$param = self::getTimestampParam('/js', $filename, $webapp);
		return $rc.$param;
	}

	public static function getJavascriptBaseUrl($webapp = FALSE) {
		return self::getWebRootUrl($webapp).'/js';
	}

	public static function getJavascriptPath($filename, $webapp = FALSE) {
		$rc    = self::getJavascriptBasePath($webapp).'/'.$filename;
		$param = self::getTimestampParam('/js', $filename, $webapp);
		return $rc.$param;
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

	public static function getCssUrl($filename, $webapp = FALSE) {
		$rc    = self::getCssBaseUrl($webapp).'/'.$filename;
		$param = self::getTimestampParam('/css', $filename, $webapp);
		return $rc.$param;
	}

	public static function getCssBasePath($webapp = FALSE) {
		return self::getWebRootPath($webapp).'/css';
	}

	public static function getCssPath($filename, $webapp = FALSE) {
		$rc    = self::getCssBasePath($webapp).'/'.$filename;
		$param = self::getTimestampParam('/css', $filename, $webapp);
		return $rc.$param;
	}

	/** @Deprecated Use getCssPath() instead */
	public static function getParametrizedCssBasePath($relativeCssFile) {
		$request = Request::getRequest();
		$mtime   = filemtime($request->appRoot.'/css'.$relativeCssFile);
		return self::getCssBasePath().$relativeCssFile.'?'.$mtime;
	}

	public static function getFontBaseUrl($webapp = FALSE) {
		return self::getWebRootUrl($webapp).'/fonts';
	}

	public static function getFontBasePath($webapp = FALSE) {
		return self::getWebRootPath($webapp).'/fonts';
	}

	public static function getLocation($subDir, $filename, $webapp = FALSE) {
		$rc = WFW_ROOT_DIR;
		if ($webapp) $rc .= WEBAPP_SUB_PATH;
		$rc .= $subDir.'/'.$filename;
		return $rc;
	}

	protected static function getTimestampParam($subDir, $filename, $webapp = FALSE) {
		$loc = self::getLocation($subDir, $filename, $webapp);
		if (file_exists($loc)) {
			return '?'.filemtime($loc);
		}
		return '';
	}
}

