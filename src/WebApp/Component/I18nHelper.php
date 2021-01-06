<?php

namespace WebApp\Component;

/**
 * A base class for creating components (usually in a form, using I18nFormElement)
 * for each available language. This class cannot be used
 * directly but is an abstract implementation. Descendants
 * need to implement #createComponent() method
 * to actually create components.
 * Users need to call #create() so the components get created.
 */
class I18nHelper {

	protected $id;
	protected $parent;
	protected $attributes;
	protected $annotations;
	protected $styles;
	protected $components;

	public function __construct($parent, $id, $languages) {
		$this->parent      = $parent;
		$this->id          = $id;
		$this->languages   = $languages;
		$this->attributes  = array();
		$this->annotations = array();
		$this->styles      = array();
		$this->components  = array();
		$this->created     = FALSE;
	}

	public function create() {
		if ($this->created) {
			throw new \WebApp\WebAppException('Language specific components already created');
		}
		foreach ($this->languages AS $key => $label) {
			$this->components[] = $this->createComponent($key, $label);
		}
		$this->created = TRUE;
	}

	/** This function must return the component */
	protected function createComponent($id, $languageKey, $languageLabel) {
		throw new \WebApp\WebAppException('You must implement #createComponent($id, $languageKey, $languageLabel)');
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->id = $id;
	}

	public function getClass() {
		return $this->getAttribute('class');
	}

	public function addClass($class) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->addAttribute('class', $class);
	}

	public function removeClass($class) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		$this->removeAttribute('class', $class);
	}

	public function hasClass($class) {
		return $this->hasAttribute('class', $class);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function setStyle($name, $value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		if ($value != NULL) {
			$this->styles[$name] = $value;
		} else {
			unset($this->styles[$name]);
		}
	}

	public function getAttributes() {
		return $this->attributes;
	}

	public function getAttribute($name, $singleValueExpected = FALSE, $defaultSingleValue = NULL) {
		$rc = NULL;
		if (isset($this->attributes[$name])) {
			$rc = $this->attributes[$name];
		}
		if ($singleValueExpected) {
			if (is_array($rc) && (count($rc) > 0)) {
				$rc = $rc[0];
				if ($rc == NULL) $rc = $defaultSingleValue;
			} else {
				$rc = $defaultSingleValue;
			}
		}
		return $rc;
	}

	public function addAttribute($name, $value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		if ($value != NULL) {
			if (!isset($this->attributes[$name])) $this->attributes[$name] = array();
			$this->attributes[$name][] = $value;
		}
	}

	public function setAttribute($name, $value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		if ($value != NULL) {
			$this->attributes[$name] = array($value);
		} else {
			unset($this->attributes[$name]);
		}
	}

	public function removeAttribute($name, $value) {
		if ($this->created) {
			throw new \WebApp\WebAppException('Invalid method call. Language specific components already created');
		}
		if (isset($this->attributes[$name])) {
			$new = array();
			foreach ($this->attributes[$name] AS $v) {
				if ($v != $value) $new[] = $v;
			}
			if (count($new) > 0) {
				$this->attributes[$name] = $new;
			} else {
				unset($this->attributes[$name]);
			}
		}
	}

	public function hasAttribute($name, $value = NULL) {
		if (isset($this->attributes[$name])) {
			$values = $this->attributes[$name];
			if ($value != NULL) {
				if (is_array($values)) return in_array($value, $values);
				return $values == $value;
			}
			return TRUE;
		}
		return FALSE;
	}

	public function getParent() {
		return $this->parent;
	}

	public function getAnntotation($key, $default = NULL) {
		return isset($this->annotations[$key]) ? $this->annotations[$key] : $default;
	}

	public function setAnntotation($key, $value) {
		$this->annotations[$key] = $value;
	}
}
