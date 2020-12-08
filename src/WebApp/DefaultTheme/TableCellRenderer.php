<?php

namespace WebApp\DefaultTheme;

class TableCellRenderer extends ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, $component->isHeading() ? 'th' : 'td');
	}
}

