<?php

namespace WebApp\Component;

class Card extends Div {

	protected $header;
	protected $body;
	protected $footer;

	public function __construct($parent) {
		parent::__construct($parent);
		$this->addClass('card');
	}

	public function addHeader($content = NULL) {
		if ($this->header == NULL) {
			$this->header = new Div($this, $content);
			$this->header->addClass('card-header');
		} else if ($content != NULL) {
			$this->header->addChild($content);
		}
		return $this->header;
	}

	public function addImage($url, $title) {
		$rc = new Image($this, $url, $title);
		$rc->addClass('card-img-top');
		return $rc;
	}

	public function addBody($content = NULL) {
		if ($this->body == NULL) {
			$this->body = new Div($this, $content);
			$this->body->addClass('card-body');
		} else if ($content != NULL) {
			$this->body->addChild($content);
		}
		return $this->body;
	}

	public function addFooter($content = NULL) {
		if ($this->footer == NULL) {
			$this->footer = new Div($this, $content);
			$this->footer->addClass('card-footer');
		} else if ($content != NULL) {
			$this->footer->addChild($content);
		}
		return $this->footer;
	}
}

