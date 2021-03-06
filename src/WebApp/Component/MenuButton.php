<?php

namespace WebApp\Component;

use \TgI18n\I18N;

class MenuButton extends MenuItem {

	public function __construct($parent, $label, $pageLink, $icon = NULL) {
		parent::__construct($parent, $label, $pageLink, $icon);
		$this->addClass('btn');
	}
}
