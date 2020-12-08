<?php

namespace WebApp;

class Renderer {

	protected $parent;
	protected $theme;
	protected $component;
	protected $attributes;
	protected $styles;

	// was __construct($theme, $parent, $component) {
	public function __construct($theme, $component) {
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

	public function addClass($class) {
		$this->addAttribute('class', $class);
	}

	public function removeClass($class) {
		$this->removeAttribute('class', $class);
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

	protected function renderStartTag($tagName) {
		$rc = '<'.$tagName;

		$rc .= ' id="'.htmlspecialchars($this->component->getId()).'"';

		// Render classes and styles first
		$classes = $this->getAttribute('class', TRUE);
		if (($classes != NULL) && (count($classes) > 0)) {
			$rc .= ' class="'.htmlspecialchars(trim(implode(' ', $classes))).'"';
		}

		$styles = $this->getStyles(TRUE);
		if (($styles != NULL) && (count($styles) > 0)) {
			$style = '';
			foreach ($styles AS $name => $value) {
				$style .= ' '.$name.':'.$value.';';
			}
			$rc .= ' style="'.htmlspecialchars(trim($style)).'"';
		}

		$attributes = $this->getAttributes(TRUE);
		unset($attributes['class']);
		foreach ($attributes AS $name => $value) {
			if (is_array($value)) $value = implode(' ', $value);
			if (is_numeric($value) || is_string($value)) {
				$rc .= ' '.$name.'="'.htmlspecialchars($value).'"';
			}
		}

		$rc .= '>';
		return $rc;
	}

	protected function renderEndTag($tagName) {
		$rc = '</'.$tagName.'>';
		return $rc;
	}

	public function getParentFor($componentName) {
		if (get_class($this->component) == $componentName) return $this;
		if ($this->parent != NULL) return $this->parent->getParentFor($componentName);
		return NULL;
	}
		
}

