<?php

namespace WebApp\Component;

class MultiImageUpload extends FormElement {

	public $images;

	public function __construct($parent, $id, $images = NULL) {
		parent::__construct($parent, $id);
		$this->images = is_array($images) ? $images : array();
	}

	public static function getImages($name) {
		$rc = array();
		$ignoreList = explode(',', \TgUtils\Request::getRequest()->getPostParam('miu-ignore-'.$name, ''));
		foreach ($_FILES AS $key => $values) {
			if (strpos($key, $name.'-') === 0) {
				for ($i=0; $i<count($values['name']); $i++) {
					if (!in_array($values['name'][$i], $ignoreList)) {
						$file = array(
							'name'      => $values['name'][$i],
							'type'      => $values['type'][$i],
							'suffix'    => FileInput::getFileSuffix($values['name'][$i], $values['type'][$i]),
							'tmp_name'  => $values['tmp_name'][$i],
							'error'     => $values['error'][$i],
							'errorText' => FileInput::getErrorText($values['error'][$i]),
							'size'      => $values['size'][$i],
						);
						$rc[] = $file;
					}
				}
			}
		}
		return $rc;
	}

	public static function getRemovedImages($name) {
		$rc = array();
		$ignoreList = explode(',', \TgUtils\Request::getRequest()->getPostParam('miu-ignore-'.$name, ''));
		foreach ($ignoreList AS $ignored) {
			$found = FALSE;
			foreach ($_FILES AS $key => $values) {
				if (strpos($key, $name.'-') === 0) {
					for ($i=0; $i<count($values['name']); $i++) {
						if ($ignored == $values['name'][$i]) {
							$found = TRUE;
							break;
						}
					}
				}
				if ($found) break;
			}
			if (!$found) $rc[] = $ignored;
		}
		return $rc;
	}
}

