<?php

namespace WebApp\BootstrapTheme;

class MenuItemRenderer extends \WebApp\DefaultTheme\ContainerRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component, 'li');
		$this->addClass('nav-item');
		if ($component->hasChildren()) $this->addClass('dropdown');
	}

	public function render() {
		$rc  = $this->renderStartTag($this->tagName);

		$link    = $this->createLink($this->component);
		$target  = $this->component->getLinkTarget() != NULL ? ' target="'.$this->component->getLinkTarget().'"' : '';
		if ($this->component->hasChildren()) {
			$rc .= '<a class="nav-link dropdown-toggle" href="'.$link.'" id="dropDown-'.$this->component->getId().'"'.$target.' role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$this->component->getLabel().'</a>'.
			       '<div class="dropdown-menu" aria-labelledby=""dropDown-'.$this->component->getId().'">';
			foreach ($this->component->getChildren() AS $child) {
				$childLink = $this->createLink($child);
				$target    = $child->getLinkTarget() != NULL ? ' target="'.$child->getLinkTarget().'"' : '';
				$rc       .= '<a class="dropdown-item" href="'.$childLink.'"'.$target.'>'.$child->getLabel().'</a>';
			}
			$rc .= '</div>';
		} else {
			$rc .= '<a class="nav-link" href="'.$link.'"'.$target.'>'.$this->component->getLabel().'</a>';
		}

		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	protected function createLink($component) {
		$rc = '#';
		$pageLink = $component->getPageLink();
		if ($pageLink != NULL) {
			if (substr($pageLink, 0, 1) != '/') {
				$rc = $pageLink;
			} else {
				$rc = $this->app->router->getCanonicalPath($pageLink);
			}
		}
		return $rc;
	}
}

