<?php

namespace WebApp\Component;

class Link extends Container {

	public function __construct($parent, $url, string $text = NULL, $target = NULL) {
		parent::__construct($parent, $text);
		$this->setAttribute('href', $url);
		$this->setAttribute('target', $target);
	}

	public function getOnClick() {
		return $this->getAttribute('onclick', TRUE);
	}

	public function setOnClick($onClick) {
		$this->setAttribute('onclick', $onClick);
		return $this;
	}

	public function getUrl() {
		return $this->getAttribute('href', TRUE);
	}

	public function setUrl($url) {
		$this->setAttribute('href', $url);
		return $this;
	}

	public function getTarget() {
		return $this->getAttribute('target', TRUE);
	}

	public function setTarget($target) {
		$this->setAttribute('target', $target);
		return $this;
	}

	public function getTitle() {
		return $this->getAttribute('title', TRUE);
	}

	public function setTitle($title) {
		$this->setAttribute('title', \TgI18n\I18N::_($title));
		return $this;
	}

	public function getEnabled() {
		return !$this->hasClass('disabled');
	}

	public function setEnabled($value) {
		if ($value) {
			$this->removeClass('disabled');
		} else {
			$this->addClass('disabled');
		}
		return $this;
	}

}

