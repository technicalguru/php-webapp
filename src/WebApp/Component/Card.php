<?php

namespace WebApp\Component;

class Card extends Div {

	public function __construct($parent) {
		parent::__construct($parent);
		$this->addClass('card');
	}

	public function addHeader($content = NULL) {
		$header = new Div($this, $content);
		$header->addClass('card-header');
		return $header;
	}

	public function addImage($url, $title) {
		$rc = new Image($this, $url, $title);
		$rc->addClass('card-img-top');
		return $rc;
	}

	public function addBody($content = NULL) {
		$body = new Div($this, $content);
		$body->addClass('card-body');
		return $body;
	}

	public function addFooter($content = NULL) {
		$footer = new Div($this, $content);
		$footer->addClass('card-footer');
		return $footer;
	}
}

