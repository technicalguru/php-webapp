<?php

namespace WebApp\Component;

class ImageUpload extends FormElement {

	public $images;

	public function __construct($parent, $id, $image = NULL) {
		parent::__construct($parent, $id);
		$this->image = $image;
	}

	public static function isImageRemoved($name) {
		$ind = intval(\TgUtils\Request::getRequest()->getPostParam('iu-remove-'.$name, 0)) == 1;
		$newFile = isset($_FILES['iu-'.$name]) && ($_FILES['iu-'.$name]['error'] == 0);
		return $newFile || $ind;
	}

	public static function getImage($name) {
		return FileInput::getFile('iu-'.$name);
	}

	public static function handleImageUpload($name, $targetDir) {
		return FileInput::handleFileUpload('iu-'.$name, $targetDir);
	}
}

