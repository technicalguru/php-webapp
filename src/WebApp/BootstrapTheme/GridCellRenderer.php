<?php

namespace WebApp\BootstrapTheme;

class GridCellRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$sizes = $this->component->getGridSizes();
		if (count($sizes) > 0) {
			foreach ($sizes AS $class => $span) {
				if ($class) $class = '-'.$class;
				if ($span > 0) {
					$this->addClass('col'.$class.'-'.$span);
				} else {
					$this->addClass('col'.$class);
				}
			}
		} else {
			$this->addClass('col');
		}
	}
}

