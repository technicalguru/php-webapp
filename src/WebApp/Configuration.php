<?php

namespace WebApp;

/**
 * Encapsulate the configuration for better handling.
 */
class Configuration {

	protected $data;

	public function __construct($config) {
		$this->data = json_decode(json_encode($config));
	}

	/**
     * Returns the given feature config as object (default) or as array.
	 */
	public function get($feature, $asArray = FALSE) {
		if ($this->has($feature)) {
			$rc = $this->data->$feature;
			if ($asArray) $rc = json_decode(json_encode($rc), TRUE);
			return $rc;
		}
		return NULL;
	}

	/**
     * Checks the existence of a feature.
     */
	public function has($feature) {
		return isset($this->data->$feature);
	}

	/** Return credentials provider when credentials are defined */
	public function getCredentialsProvider($feature, $vault) {
		if (($vault != NULL) && $this->has($feature)) {
			if (!isset($this->credentialProviders->$feature)) {
				if (!isset($this->credentialProviders)) $this->credentialProviders = new \stdClass;
				$this->credentialProviders->$feature = NULL;
				if (isset($this->data->$feature->security) && ($this->data->$feature->security->type == 'vault')) {
					$path    = $this->data->$feature->security->path;
					$userKey = isset($this->data->$feature->security->userKey) ? $this->data->$feature->security->userKey : 'username';
					$passKey = isset($this->data->$feature->security->passKey) ? $this->data->$feature->security->passKey : 'password';
					$this->credentialProviders->$feature = new \TgVault\CredentialsProvider($vault, $path, $userKey, $passKey);
				}
			}
			return $this->credentialProviders->$feature;
		}
		return NULL;
	}

	/** Create from PHP array */
	public static function fromPhpFile($filename) {
		if (file_exists($filename)) {
			return new Configuration(include($filename));
		}
		throw new WebAppException('Cannot read configuration from: '.$filename);
	}

	/** Create from JSON file */
	public static function fromJsonFile($filename) {
		if (file_exists($filename)) {
			return self::fromJson(file_get_contents($filename));
		}
		throw new WebAppException('Cannot read configuration from: '.$filename);
	}

	/** Create from JSON string */
	public static function fromJson($json) {
		return new Configuration(json_decode($json, TRUE));
	}
}

