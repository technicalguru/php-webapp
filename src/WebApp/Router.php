<?php

namespace WebApp;

use TgLog\Log;
use TgI18n\I18N;

/** A Router handles the path-to-page mapping and the language detection. */
class Router {

	protected $pageMap;
	protected $request;
	protected $languages;
	protected $defaultLanguage;

	public function __construct($app, $config = NULL) {
		$this->app     = $app;
		$this->request = $this->app->request;

		// Make it an array just in case
		if (is_object($config)) $config = json_decode(json_encode($config), TRUE);

		$this->pageMap = isset($config['pageMap']) ? $config['pageMap'] : NULL;

		if (isset($config['languages'])) {
				$this->languages = $config['languages'];
		} else {
			$this->languages = array();
		}

		if (count($this->languages) > 0) {
			if (isset($config['defaultLanguage']) && isset($this->languages[$config['defaultLanguage']])) {
				$this->defaultLanguage = $config['defaultLanguage'];
			} else {
				$this->defaultLanguage = array_keys($this->languages)[0];
			}
			I18N::$defaultLangCode   = $this->defaultLanguage;
		} else {
			$this->defaultLanguage = NULL;
			I18N::$defaultLangCode   = 'en';
		}

	}

	public function getDefaultLanguage() {
		return $this->defaultLanguage;
	}

	public function hasLanguage($langCode) {
		return isset($this->languages[$langCode]);
	}

	/**
	 * Returns an array $path-fragment => $pageClassName/$namespaceName
	 * When path mapping happens, the longest match will be used (first one)
	 * If the name ends with a backslash (\) then it is assumed to be a namespace
	 * which means that a class will be used. Example:
	 * configured map:       '/mypath/something' => 'Something\'
	 * requested path:       '/mypath/something/doSomething.html'
	 * resulting page class: 'Something\DoSomethingPage'
	 * class and namespace names must be complete! (no relative names)
	 */
	public function getPageMap() {
		if (isset($this->pageMap)) {
			return $this->pageMap;
		}
		return array(
			'/' => 'WebApp\\Page\\',
		);
	}

	/** 
	 * Returns the absolute canonical URI path for a page path from the app root.
	 * <p>Returns the canonical path for the current URI when no arguments given.</p>
	 * @param string $localPath - an appRoot-relative path without language (u
	 * @param string $language - the language to be used
	 * @return string the absolute path for the URI.
	 */
	public function getCanonicalPath($pagePath = NULL, $language = NULL) {
		if (!isset($this->request->canonicalPath)) {
			$this->initPagePath();
		}
		if (($pagePath == NULL) && ($language != NULL)) $pagePath = $this->request->pagePath;
		if ($pagePath != NULL) {
			return $this->computeCanonicalPath($pagePath, $language);
		}
		return $this->request->canonicalPath;
	}

	/** 
	 * Computes the absolute canonical URI path for a page path from the app root.
	 * @param string $pagePath - a page path
	 * @param string $language - the language to be used
	 * @return string the absolute, canonical path for the page with this language.
	 */
	protected function computeCanonicalPath($pagePath, $language) {
		if ($language == NULL) $language = $this->request->language;
		if (!$this->request->useLanguagePath || ($language == NULL)) $language = '';
		else $language = '/'.$language;

		return $this->getAbsolutePath($language.$pagePath);
	}

	public function getPagePath() {
		if (!isset($this->request->pagePath)) {
			$this->initPagePath();
		}
		return $this->request->pagePath;
	}

	/**
	 * Initialize canonical path, page path and language 
	 */
	protected function initPagePath() {
		$this->request->language = NULL;
		$this->request->canonicalPath = substr($this->request->path, strlen($this->request->relativeAppPath));
		$this->request->pagePath      = $this->request->canonicalPath;

		// strip off app path from path
		$pathElems = explode('/', $this->request->pagePath);
		while ($pathElems[0] === '') array_shift($pathElems);
		// Check language
		if (count($pathElems) > 0) {
			if ($this->hasLanguage($pathElems[0])) {
				$this->request->language = $pathElems[0];
				$this->request->pagePath = substr($this->request->pagePath, strlen($pathElems[0])+1);
				array_shift($pathElems);
			} else if (count($this->languages) > 1) {
				$this->request->canonicalPath = '/'.$this->getDefaultLanguage().$this->request->pagePath;
				$this->request->language      = $this->getDefaultLanguage();
			} else {
				$this->request->language = $this->getDefaultLanguage();
			}
		}
		while ($pathElems[0] === '') array_shift($pathElems);
		$this->request->pagePathElements = $pathElems;
		$this->request->useLanguagePath  = count($this->languages) > 1;

		// needs to be fixed when we removed all path elements before
		if ($this->request->pagePath == '') $this->request->pagePath = '/';

		if ($this->request->language != NULL) {
			I18N::$defaultLangCode   = $this->request->language;
		}
	}

	/**
	 * Returns the page to be displayed or NULL if no page can be found matching the path.
	 * <p>Path mapping is used as defined by getPageMap()</p>
	 */
	public function getPage() {
		$page     = NULL;
		$pageMap  = $this->getPageMap();
		$pagePath = $this->getPagePath();

		// Find the longest matching entry in map
		$mapEntry = NULL;
		foreach ($pageMap AS $pathRoot => $name) {
			if (strpos($pagePath, $pathRoot) === 0) {
				if (($mapEntry == NULL) || (strlen($pathRoot) > strlen($mapEntry))) {
					$mapEntry = $pathRoot;
				}
			}
		}

		$className = NULL;
		if ($mapEntry != NULL) {
			$name = $pageMap[$mapEntry];
			if (substr($name, -1) == '\\') {
				// Namespace defined

				// Strip of the leading part
				$afterName = substr($pagePath, strlen($mapEntry));

				// Fix special cases such as empty start or trailing slash
				if ($afterName == '')              $afterName .= '/index';
				if (substr($afterName, -1) == '/') $afterName .= 'index';

				// strip of the ending .html
				if (substr($afterName, -5) == '.html') $afterName = substr($afterName, 0, strlen($afterName)-5);

				// split in parts and remove first part if it's empty
				$names     = explode('/', $afterName);
				if ($names[0] == '') array_shift($names);

				// Replace special characters by whitespace and make it camel case and concatenate again
				$className = $name;
				foreach ($names AS $idx => $path) {
					if ($idx > 0) $className .= '\\';
					$path       = str_replace(' ', '', ucwords(str_replace(array('_','-'), array(' ', ' '), $path)));
		            $className .= ucfirst($path);
				}

				// Make a bottom-2-top search for the class as long as you are in the namespace of the mapEntry
				$toSearch = '\\'.$className.'Page';
				while (!class_exists($toSearch) && (strpos($toSearch, $pageMap[$mapEntry]) !== FALSE)) {
					// strip off from last backslash
					$toSearch = substr($toSearch, 0, strrpos($toSearch, '\\')).'Page';
				}
				if (class_exists($toSearch)) {
					$className = $toSearch;
				} else {
					$className .= 'Page';
				}
			} else {
				// Single Page
				$className = $name;
			}
		}

		// Check whether the class exists
		if ($className != NULL) {
			if (substr($className, 0, 1) != '\\') $className = '\\'.$className;
			if (class_exists($className)) $page = new $className($this->app);
		}

		return $page;
	}

	/** Returns the absolute path to a relative app path */
	public function getAbsolutePath($relativePath) {
		$request = $this->app->request;
		return $request->webRoot.$request->relativeAppPath.$relativePath;
	}

}

