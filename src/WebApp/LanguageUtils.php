<?php

namespace WebApp;

class LanguageUtils {

	public static function getPreferredUserLanguage($priorities) {
		$header = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$rc     = self::getBest($header, $priorities);
		if ($rc == NULL) {
			// Search the languages, e.g. iOS does not return the general language
			$matches = array();
			$res = preg_match_all('/(?:[^,"]*+(?:"[^"]*+")?)+[^,"]*+/', $header, $matches);
			$accepted   = array_values(array_filter(array_map('trim', $matches[0])));
			$additional = array();
			foreach ($accepted AS $lang) {
				if (strpos($lang, '-') > 0) {
					$shortLang = substr($lang, 0, 2);
					if (!in_array($shortLang, $accepted)) {
						$additional[] = $shortLang;
					}
				}
			}

			if (count($additional) > 0) {
				$header .= ','.implode(',', $additional);
				$rc     = self::getBest($header, $priorities);
			}
		}

		if ($rc == NULL) {
			$rc = $priorities[0];
		}

		return $rc;
	}

	protected static function getBest($header, $priorities) {
		$negotiator = new \Negotiation\LanguageNegotiator();
		if (\TgUtils\Utils::isEmpty($header)) $header = 'en-US,en';
		$best       = $negotiator->getBest($header, $priorities);
		if ($best != NULL) {
			return $best->getType();
		}
		return NULL;
	}

}

