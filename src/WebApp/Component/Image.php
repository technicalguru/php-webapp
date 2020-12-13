<?php

namespace WebApp\Component;

class Image extends Component {

	public function __construct($parent, $url, $title) {
		parent::__construct($parent);
		$this->setAttribute('src', $url);
		$this->setAttribute('title', $title);
	}

	public function getUrl() {
		return $this->getAttribute('href', TRUE);
	}

	public function setUrl($url) {
		$this->setAttribute('href', $url);
	}

	public function getTitle() {
		return $this->getAttribute('title', TRUE);
	}

	public function setTitle($title) {
		$this->setAttribute('title', $title);
	}

}

