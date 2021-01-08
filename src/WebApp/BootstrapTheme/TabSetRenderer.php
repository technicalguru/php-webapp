<?php

namespace WebApp\BootstrapTheme;

class TabSetRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('tabbable');
		$theme->addFeature(BootstrapTheme::TABS);
	}

	protected function setActiveTab() {
		$active = NULL;
		$first  = NULL;
		foreach ($this->component->getChildren() AS $tab) {
			if ($first == NULL) $first = $tab;
			if (($active == NULL) && $tab->isActive()) $active = $tab;
		}
		if ($active == NULL) $active = $first;
		foreach ($this->component->getChildren() AS $tab) {
			$tab->setActive($tab == $active);
		}
	}

	public function render() {
		$this->setActiveTab();
		$rc = $this->renderStartTag($this->tagName);
		$rc .= $this->renderNavigation();
		$rc .= $this->renderContent();
		$rc .= $this->renderEndTag($this->tagName);
		return $rc;
	}

	public function renderNavigation() {
		$idPrefix       = $this->component->getId().'-nav';
		$tabPrefix      = $this->component->getId().'-tab';
		$navLinkClasses = implode(' ', $this->component->getNavLinkClasses());
		$rc = '<ul id="'.$idPrefix.'" class="nav nav-tabs">';
		foreach ($this->component->getChildren() AS $tab) {
			$id    = $idPrefix.'-'.$tab->getId();
			$tabId = $tabPrefix.'-'.$tab->getId();
			$classes = implode(' ', $tab->getNavLinkClasses());
			$rc .= '<li id="'.$id.'" '.($tab->isActive() ? 'class="active"' : '').'>'.
			         '<a href="#'.$tabId.'" class="nav-link '.$navLinkClasses.($tab->isActive() ? ' active' : '').' '.$classes.'">'.$tab->getLabel().'</a>'.
			      '</li>';
		}
		$rc .= '</ul>';
		return $rc;
	}

	public function renderContent() {
		$idPrefix       = $this->component->getId().'-tab';
		$tabPaneClasses = implode(' ', $this->component->getTabPaneClasses());
		$rc = '<div id="'.$idPrefix.'" class="tab-content">';
		foreach ($this->component->getChildren() AS $tab) {
			$id  = $idPrefix.'-'.$tab->getId();
			$tab->setId($id);
			$tab->addClass($tabPaneClasses);
			$rc .= $this->theme->renderComponent($tab);
		}
		$rc .= '</div>';
		return $rc;
	}
}

