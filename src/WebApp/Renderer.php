<?php

namespace WebApp;

class Renderer {

	protected $parent;
	protected $app;
	protected $theme;
	protected $component;
	protected $attributes;
	protected $styles;

	// was __construct($theme, $parent, $component) {
	public function __construct($theme, $component) {
		$this->app        = $theme->app;
		$this->theme      = $theme;
		$this->parent     = $parent;
		$this->component  = $component;
		$this->attributes = array();
		$this->styles     = array();
	}

	public function render() {
		return 'Cannot render component '.get_class($this->component);
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

	public function removeClass(...$classes) {
		foreach ($classes AS $class) {
			$this->removeAttribute('class', $class);
		}
		return $this;
	}

	public function hasClass($class) {
		return $this->hasAttribute('class', $class);
	}

	public function getStyles($combined = FALSE) {
		if ($combined) {
			return array_merge($this->component->getStyles(), $this->styles);
		}
		return $this->styles;
	}

	public function setStyle($name, $value) {
		if ($value != NULL) {
			$this->styles[$name] = $value;
		} else {
			unset($this->styles[$name]);
		}
		return $this;
	}

	protected function getAttribute($name, $combined = FALSE) {
		$rc = $this->attributes[$name];
		if ($combined) {
			if (isset($rc)) {
				$rc = $this->_combineValues($this->component->getAttribute($name), $rc);
			} else {
				$rc = $this->component->getAttribute($name);
			}
		}
		return $rc;
	}

	protected function getAttributes($combined = FALSE) {
		$rc = $this->attributes;
		if ($combined) {
			$componentAttributes = $this->component->getAttributes();
			$keys = array_merge(array_keys($rc), array_keys($componentAttributes));
			$attributes = array();
			foreach ($keys AS $key) {
				if (isset($componentAttributes[$key])) {
					$c1 = $componentAttributes[$key];
					if (isset($rc[$key])) {
						$c2 = $rc[$key];
						$attributes[$key] = $this->_combineValues($c1, $c2);
					} else {
						$attributes[$key] = $c1;
					}
				} else {
					$attributes[$key] = $rc[$key];
				}
			}
			$rc = $attributes;
		}
		return $rc;
	}

	private function _combineValues($v1, $v2) {
		$rc = array();
		
		if (is_array($v1)) $rc   = $v1;
		else               $rc[] = $v1;

		if (is_array($v2)) {
			foreach ($v2 AS $v) {
				if (!in_array($v, $rc)) $rc[] = $v;
			}
		} else if (!in_array($v2, $rc)) $rc[] = $v2;

		return $rc;
	}

	public function addAttribute($name, $value) {
		if ($value != NULL) {
			if (!isset($this->attributes[$name])) $this->attributes[$name] = array();
			$this->attributes[$name][] = $value;
		}
		return $this;
	}

	public function setAttribute($name, $value) {
		if ($value != NULL) {
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
			if ($value != NULL) {
				if (is_array($values)) return in_array($value, $values);
				return $values == $value;
			}
			return TRUE;
		}
		return FALSE;
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

	protected function renderStartTag($tagName, $closeTag = FALSE) {
		$attributes = $this->computeFinalAttributes();
		return \TgUtils\Html::renderStartTag($tagName, $attributes, $closeTag);
	}

	public function computeFinalAttributes() {
		$rc = array();

		$rc['id'] = $this->component->getId();

		// classes
		$classes = $this->getAttribute('class', TRUE);
		if (($classes != NULL) && (count($classes) > 0)) {
			$rc['class'] =  $classes;
		}

		$styles = $this->getStyles(TRUE);
		if (($styles != NULL) && (count($styles) > 0)) {
			$style = '';
			foreach ($styles AS $name => $value) {
				$style .= ' '.$name.':'.$value.';';
			}
			$rc['style'] = trim($style);
		}

		$attributes = $this->getAttributes(TRUE);
		unset($attributes['class'], $attributes['style'], $attributes['id']);
		foreach ($attributes AS $name => $value) {
			$rc[$name] = $value;
		}
		return $rc;
	}

	protected function renderEndTag($tagName) {
		return \TgUtils\Html::renderEndTag($tagName);
	}

	public function getParentFor($componentName) {
		if (get_class($this->component) == $componentName) return $this;
		if ($this->parent != NULL) return $this->parent->getParentFor($componentName);
		return NULL;
	}

}

