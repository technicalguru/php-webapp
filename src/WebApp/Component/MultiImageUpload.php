<?php

namespace WebApp\Component;

use TgI18n\I18N;
use TgLog\Log;
use TgLog\Error;

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

	public static function handleImageUpload($name, $targetDir) {
		$files = self::getImages($name);
		$rc    = array();
		foreach ($files AS $file) {
			$file['filename'] = NULL;
			if ($file['error'] == 0) {
				$fileUid    = \TgUtils\Utils::generateRandomString(10);
				$targetFile  = $targetDir.'/'.$fileUid.'.'.$file['suffix'];
				while (file_exists($targetFile)) {
					$fileUid    = \TgUtils\Utils::generateRandomString(10);
					$targetFile  = $targetDir.'/'.$fileUid.'.'.$file['suffix'];
				}
				if (move_uploaded_file($file['tmp_name'], $targetFile)) {
					$file['id']       = $fileUid;
					$file['filename'] = $fileUid.'.'.$file['suffix'];

					// Enrich with metadata
					$info           = getimagesize($targetDir.'/'.$file['filename']);
					$file['mime']   = $info['mime'];
					$file['width']  = $info[0];
					$file['height'] = $info[1];
					$file['ratio']  = $info[0] / $info[1];
				} else {
					Log::register(new Error('<b>'.$file['name'].':</b> '.I18N::_('error_cannot_store_image')));
					Log::error('move_uploaded_file('.$file['tmp_name'].','.$targetFile.')');
				}
			} else {
				Log::register(new Error('<b>'.$file['name'].':</b> '.$file['errorText']));
			}
			$rc[] = $file;
		}
		return $rc;
	}
}

