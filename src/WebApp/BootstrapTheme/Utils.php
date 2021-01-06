<?php

namespace WebApp\BootstrapTheme;

class Utils {

	public static function renderIcon($name, $type = 'fas', $size = '') {
		$rc = '<i class="'.$type.' fa-'.$name.'"></i>';
		return $rc;
	}

}
