<?php

namespace WebApp\Component;

use TgLog\Log;
use TgLog\Error;

class FileInput extends Input {

	public function __construct($parent, $id) {
		parent::__construct($parent, $id, 'file');
	}

	public static function getFile($name) {
		$rc = NULL;
		if (isset($_FILES[$name]) && ($_FILES[$name]['error'] != 4)) {
			$rc = array(
				'name'      => $_FILES[$name]['name'],
				'type'      => $_FILES[$name]['type'],
				'suffix'    => self::getFileSuffix($_FILES[$name]['name'], $_FILES[$name]['type']),
				'tmp_name'  => $_FILES[$name]['tmp_name'],
				'error'     => $_FILES[$name]['error'],
				'errorText' => self::getErrorText($_FILES[$name]['error']),
				'size'      => $_FILES[$name]['size'],
			);
		}
		return $rc;
	}

	public static function getErrorText($errorCode) {
		if ($errorCode != 0) {
			$message = NULL;
			switch ($errorCode) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$message = array(
						'de' => 'Die Datei ist zu gro&szlig;. Es sind maximal '.ini_get('upload_max_filesize').' erlaubt.',
						'en' => 'The file is too big. Maximum allowed filesize is '.ini_get('upload_max_filesize').'.',
					);
					break;
				case UPLOAD_ERR_PARTIAL:
					$message = array(
						'de' => 'Die Datei wurde nur teilweise &uuml;bertragen. Bitte versuche es erneut!',
						'en' => 'The file was transmitted partially only. Please try again!',
					);
					break;
				case UPLOAD_ERR_NO_FILE:
					$message = array(
						'de' => 'Es wurde keine Datei &uuml;bertragen. Bitte versuche es erneut!',
						'en' => 'No file was transmitted. Please try again!',
					);
					break;
				case UPLOAD_ERR_NO_TMP_DIR:
				case UPLOAD_ERR_CANT_WRITE:
				case UPLOAD_ERR_EXTENSION:
					$message = array(
						'de' => 'Die Datei konnte nicht gespeichert werden. Wir arbeiten daran.',
						'en' => 'The file could not be stored. We are working on it.',
					);
					break;
				default:
					$message = array(
						'de' => 'Ein Fehler ist aufgetreten. Wir arbeiten daran.',
						'en' => 'An internal error occurred. We are working on it.',
					);
			}
			return \TgI18n\I18N::_($message);
		}
		return NULL;
	}

	public static function handleFileUpload($name, $targetDir) {
		$file = self::getFile($name);
		if ($file != NULL) {
			$file['filename'] = NULL;
			if ($file['error'] == 0) {
				$fileUid    = \TgUtils\Utils::generateRandomString(10);
				$targetFile  = $targetDir.'/'.$fileUid.'.'.$file['suffix'];
				while (file_exists($targetFile)) {
					$fileUid    = \TgUtils\Utils::generateRandomString(10);
					$targetFile  = $targetDir.'/'.$fileUid.'.'.$file['suffix'];
				}
				if (move_uploaded_file($file['tmp_name'], $targetFile)) {
					$file['filename'] = $fileUid.'.'.$file['suffix'];
				} else {
					Log::register(new Error($file['name'].': '.I18N::_('error_cannot_store_file')));
					Log::error('move_uploaded_file('.$file['tmp_name'].','.$targetFile.')');
				}
			} else {
				Log::register(new Error($file['name'].': '.$file['errorText']));
			}
		}
		return $file;
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

