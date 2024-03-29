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
	public    $customId;

	public function __construct($parent) {
		$this->parent      = $parent;
		$this->uid         = self::createUid();
		$this->id          = $this->uid;
		if ($this->parent  != NULL && method_exists($this->parent, 'addChild')) $this->parent->addChild($this);
		$this->attributes  = array();
		$this->annotations = array();
		$this->styles      = array();
		$this->customId    = FALSE;
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
		$this->customId = TRUE;
		return $this;
	}

	public function getClass() {
		return $this->getAttribute('class');
	}

	public function addClass(...$classes) {
		foreach ($classes AS $class) {
			$this->addAttribute('class', $class);
		}
		return $this;
	}

	public function removeClass($class) {
		$this->removeAttribute('class', $class);
		return $this;
	}

	public function hasClass($class) {
		return $this->hasAttribute('class', $class);
	}

	public function getStyles() {
		return $this->styles;
	}

	public function getStyle($name) {
		return isset($this->styles[$name]) ? $this->styles[$name] : NULL;
	}

	public function setStyle($name, $value) {
		if ($value !== NULL) {
			$this->styles[$name] = $value;
		} else {
			unset($this->styles[$name]);
		}
		return $this;
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
		if ($value !== NULL) {
			if (!isset($this->attributes[$name])) $this->attributes[$name] = array();
			$this->attributes[$name][] = $value;
		}
		return $this;
	}

	public function setAttribute($name, $value) {
		if ($value !== NULL) {
			$this->attributes[$name] = array($value);
		} else {
			unset($this->attributes[$name]);
		}
		return $this;
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
		return $this;
	}

	public function hasAttribute($name, $value = NULL) {
		if (isset($this->attributes[$name])) {
			$values = $this->attributes[$name];
			if ($value !== NULL) {
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

	public function getAnnotations() {
		return $this->annotations;
	}

	public function getAnnotation($key, $default = NULL) {
		return isset($this->annotations[$key]) ? $this->annotations[$key] : $default;
	}

	public function setAnnotation($key, $value) {
		$this->annotations[$key] = $value;
		return $this;
	}

	public function getData($key) {
		return $this->getAttribute('data-'.$key, TRUE);
	}

	public function setData($key, $value) {
		$this->setAttribute('data-'.$key, $value);
		return $this;
	}

	public function getAria($key) {
		return $this->getAttribute('aria-'.$key, TRUE);
	}

	public function setAria($key, $value) {
		$this->setAttribute('aria-'.$key, $value);
		return $this;
	}

	public function getPageParent() {
		$rc = $this->getParent();
		while (($rc != NULL) && !is_a($rc, 'WebApp\\Page')) {
			$rc = $rc->getParent();
		}
		return $rc;
	}

}

