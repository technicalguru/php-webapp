<?php

namespace WebApp\Component;

class ImageCarousel extends Div {

	protected $images;

	public function __construct($parent) {
		parent::__construct($parent);
		$this->images = array();
	}

	public function addImage($image, $title = NULL, $description = NULL) {
		$img = new \stdClass;
		$img->image      = is_string($image) ? new Image($this, $image, $title) : $image;
		$img->title      = $title;
		$img->descripton = $description;
		$this->images[]  = $img;
	}

	public function getImages() {
		return $this->images;
	}
}

