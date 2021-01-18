<?php

namespace WebApp\Component;

class FileInput extends Input {

	public function __construct($parent, $id) {
		parent::__construct($parent, $id, 'file');
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
}

