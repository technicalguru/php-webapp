<?php

namespace WebApp\Component;

class NewImageUpload extends Div {

	protected $config;

	public function __construct($parent, $id, $config) {
		parent::__construct($parent);
		$this->setId($id);
		$this->config = $config;
	}

	public function hasNavigation() {
		return $this->config->maxImages > 1;
	}

	public function getMaxImages() {
		return $this->config->maxImages;
	}

	public function getUriDir() {
		return $this->config->uriDir;
	}

	public function getImageCount() {
		return count($this->config->images);
	}

	public function getImages() {
		return $this->config->images;
	}

	public function getWidth() {
		return $this->config->width;
	}

	public function getHeight() {
		return $this->config->height;
	}

	public function getAspectRatio() {
		if (!isset($this->config->aspectRatio)) {
			$this->config->aspectRatio = round($this->config->width / $this->config->height, 2);
		}
		return $this->config->aspectRatio;
	}
}

