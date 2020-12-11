<?php

namespace WebApp\DefaultTheme;

class TableBodyRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'tbody');
	}
}

