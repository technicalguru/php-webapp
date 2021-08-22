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

	
/*
	public static function isImageRemoved($name) {
		$ind = intval(\TgUtils\Request::getRequest()->getPostParam('iu-remove-'.$name, 0)) == 1;
		$newFile = isset($_FILES['iu-'.$name]) && ($_FILES['iu-'.$name]['error'] == 0);
		return $newFile || $ind;
	}

	public static function getImage($name) {
		return FileInput::getFile('iu-'.$name);
	}

	public static function handleImageUpload($name, $targetDir) {
		$rc = FileInput::handleFileUpload('iu-'.$name, $targetDir);
		if (($rc != NULL) && ($rc['filename'] != NULL)) {
			$info = getimagesize($targetDir.'/'.$rc['filename']);
			$rc['mime']   = $info['mime'];
			$rc['width']  = $info[0];
			$rc['height'] = $info[1];
			$rc['ratio']  = $info[0] / $info[1];
		}
		return $rc;
	}
*/
}

