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

}

