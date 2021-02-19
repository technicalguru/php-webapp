<?php

namespace WebApp\Component;

class Container extends Component {

	protected $children;

	public function __construct($parent, $content = NULL) {
		parent::__construct($parent);
		$this->children = array();
		if ($content != NULL) {
			if (is_string($content)) {
				new Text($this, $content);
			} else {
				$this->addChild($content);
			}
		}
	}

	public function addChild($child) {
		$this->children[] = $child;
	}

	public function addChildAt($child, $index) {
		array_splice($this->children, $index, 0, array($child));
	}

	public function addChildBefore($child, $member) {
		$arr = array();
		$inserted = FALSE;
		foreach ($this->children AS $m) {
			if ($m == $member) {
				$arr[]    = $child;
				$inserted = TRUE;
			}
			$arr[] = $m;
		}
		if (!$inserted) $arr[] = $child;
		$this->children = $arr;
	}

	public function addChildAfter($child, $member) {
		$arr = array();
		$inserted = FALSE;
		foreach ($this->children AS $m) {
			$arr[] = $m;
			if ($m == $member) {
				$arr[]    = $child;
				$inserted = TRUE;
			}
		}
		if (!$inserted) $arr[] = $child;
		$this->children = $arr;
	}

	public function moveChildTo($child, $index) {
		$this->removeChild($child);
		$this->addChildAt($child, $index);
	}

	public function moveChildBefore($child, $member) {
		$this->removeChild($child);
		$this->addChildBefore($child, $member);
	}

	public function moveChildAfter($child, $member) {
		$this->removeChild($child);
		$this->addChildAfter($child, $member);
	}

	public function removeChild($child) {
		$a = array();
		foreach ($this->children AS $c) {
			if ($child != $c) $a[] = $c;
		}
		$this->children = $a;
	}

	public function getChildren() {
		return $this->children;
	}

	public function hasChildren() {
		return count($this->children) > 0;
	}
}

