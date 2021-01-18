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
		$rc = NULL;
		if (isset($_FILES['iu-'.$name]) && ($_FILES['iu-'.$name]['error'] != 4)) {
			$rc = array(
				'name'      => $_FILES['iu-'.$name]['name'],
				'type'      => $_FILES['iu-'.$name]['type'],
				'suffix'    => self::getFileSuffix($_FILES['iu-'.$name]['name'], $_FILES['iu-'.$name]['type']),
				'tmp_name'  => $_FILES['iu-'.$name]['tmp_name'],
				'error'     => $_FILES['iu-'.$name]['error'],
				'errorText' => FileInput::getErrorText($_FILES['iu-'.$name]['error']),
				'size'      => $_FILES['iu-'.$name]['size'],
			);
		}
		return $rc;
	}

	public static function getFileSuffix($filename, $type = NULL) {
		$pos = strrpos($name, '.');
		if ($pos > 0) {
			return strtolower(substr($name, $pos+1));
		} else if (($type != NULL) && (strpos($type, 'image/') === 0)) {
			return substr($type, 6);
		}
		return 'unknown';
	}

}

