<?php

namespace WebApp\Component;

class Component {

	private static $uidCount = 0;

	protected $uid;
	protected $id;
	protected $parent;
	protected $attributes;
	protected $annotations;
	protected $styles;

	public function __construct($parent) {
		$this->parent      = $parent;
		$this->uid         = self::createUid();
		$this->id          = $this->uid;
		if ($this->parent  != NULL && method_exists($this->parent, 'addChild')) $this->parent->addChild($this);
		$this->attributes  = array();
		$this->annotations = array();
		$this->styles      = array();
	}

	private static function createUid() {
		if (self::$uidCount == 0) {
			$random = rand(100, 999);
			self::$uidCount = intval($random.time().'0000');
		}
		self::$uidCount++;
		return 'c'.self::$uidCount;
	}

	public function getUid() {
		return $this->uid;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getClass() {
		return $this->getAttribute('class');
	}

	public function addClass($class) {
		$this->addAttribute('class', $class);
	}

	public function removeClass($class) {
		$this->removeAttribute('class', $class);
	}

	public function hasClass($class) {
		return $this->hasAttribute('class', $class);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function setStyle($name, $value) {
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
		if ($value != NULL) {
			if (!isset($this->attributes[$name])) $this->attributes[$name] = array();
			$this->attributes[$name][] = $value;
		}
	}

	public function setAttribute($name, $value) {
		if ($value != NULL) {
			$this->attributes[$name] = array($value);
		} else {
			unset($this->attributes[$name]);
		}
	}

	public function removeAttribute($name, $value) {
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

	public function getAnntotations() {
		return $this->annotations;
	}

	public function getAnntotation($key, $default = NULL) {
		return isset($this->annotations[$key]) ? $this->annotations[$key] : $default;
	}

	public function setAnntotation($key, $value) {
		$this->annotations[$key] = $value;
	}
}

