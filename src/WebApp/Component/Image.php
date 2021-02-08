<?php

namespace WebApp\Component;

class Image extends Component {

	public function __construct($parent, $url, $title) {
		parent::__construct($parent);
		$this->setUrl($url);
		$this->setTitle($title);
	}

	public function getUrl() {
		return $this->getAttribute('src', TRUE);
	}

	public function setUrl($url) {
		$this->setAttribute('src', $url);
	}

	public function getTitle() {
		return $this->getAttribute('title', TRUE);
	}

	public function setTitle($title) {
		$this->setAttribute('title', $title);
	}

}

