<?php

namespace WebApp\BootstrapTheme;

class DropDownRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('dropdown');

		$button = $component->getButton();
		$button->addClass('btn');
		$button->addClass('dropdown-toggle');
		$button->setAttribute('data-toggle', 'dropdown');
		$button->setAttribute('aria-haspopup', 'true');
		$button->setAttribute('aria-expanded', 'false');

		$menu = $component->getMenu();
		$menu->addClass('dropdown-menu');
		$menu->setAttribute('aria-labelledby', $button->getId());
		foreach ($menu->getChildren() AS $child) {
			if (is_a($child, 'WebApp\\Component\\Link')) {
				$child->addClass('dropdown-item');
			} else if (is_a($child, 'WebApp\\Component\\Div') && !$child->hasChildren()) {
				$child->addClass('dropdown-divider');
			}
		}
	}
}

