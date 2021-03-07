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
			       '<div class="dropdown-menu bg-dark" aria-labelledby=""dropDown-'.$this->component->getId().'">';
			foreach ($this->component->getChildren() AS $child) {
				switch(get_class($child)) {
				case 'WebApp\Component\MenuItem':
					$childLink = $this->createLink($child);
					$target    = $child->getLinkTarget() != NULL ? ' target="'.$child->getLinkTarget().'"' : '';
					$rc .= '<a class="dropdown-item nav-link" href="'.$childLink.'"'.$target.'>'.$child->getLabel().'</a>';
					break;
				case 'WebApp\Component\MenuButton':
					$childLink = $this->createLink($child);
					$target    = $child->getLinkTarget() != NULL ? ' target="'.$child->getLinkTarget().'"' : '';
					$rc .= '<div class="dropdown-button"><a class="btn btn-light" href="'.$childLink.'"'.$target.'>'.$child->getLabel().'</a></div>';
					break;
				case 'WebApp\Component\Divider':
					$rc .= '<div class="dropdown-divider"></div>';
					break;
				default:
					$rc .= $this->theme->renderComponent($child);
					break;
				}
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
			$rc = $pageLink;
		}
		return $rc;
	}
}

