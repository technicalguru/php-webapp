<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;
use WebApp\Utils;

/** A layout using Mmenu */
class MmenuLayout extends DefaultLayout {

	protected $menuStyles;
	protected $staticMenuConfig;
	protected $menuOptions;
	protected $menuConfig;

	public function __construct($theme, $page) {
		parent::__construct($theme, $page);
		$this->hasMenu          = FALSE;
		$this->menu             = NULL;
		$this->menuStyles       = array();
		$this->staticMenuConfig = array();
		$this->menuOptions      = NULL;
		$this->menuConfig       = NULL;
	}

	protected function renderLinks() {
		$webroot = Utils::getWebRootPath(TRUE);
		$rc  = parent::renderLinks();
		$rc .= '<link rel="stylesheet" href="'.$webroot.'/mmenu/mmenu.css" type="text/css">';
		return $rc;
	}

	protected function renderBody() {
		$this->menu = $this->app->getMenu();
		$this->hasMenu = ($this->menu != NULL) && is_array($this->menu);

		$rc = '<body lang="'.$this->app->request->language.'">'.
		         '<div id="the-page" class="full-page">'.
			       $this->renderNavbar().
		           $this->renderMmenu().
			       $this->renderContent().
			       $this->renderFooter().
				   $this->theme->renderComponent($this->renderLog()).
		         '</div>'.
				 $this->renderJavascript().
		      '</body>';
		return $rc;
	}

	protected function renderNavbar() {
		$rc = '<nav class="navbar bg-white sticky-top" style="flex-flow: nowrap;justify-content: space-between; align-content: center;">';
		if (!$this->app->isMaintenance()) {
			$rc .= $this->renderNavbarToggler();
		}
		$rc .= $this->renderNavbarBrand();
		if (!$this->app->isMaintenance()) {
			$rc .= $this->renderNavbarContent();
		}
		$rc .= '</nav>';
		return $rc;
	}

	protected function renderNavbarToggler() {
		$rc = '<span class="navbar-brand mb-0 display-4" style="margin-right: auto;"><a href="#mmenu"><span class="fas fa-bars"></span></a></span>';
		return $rc;
	}

	protected function renderNavbarContent() {
		$rc   = '<div id="navbar-content" style="margin-left: auto;">'.
		        '</div>';
		$userMenu = $this->app->getMenu('user');
		if ($userMenu != NULL) {
			$rc .= '<ul class="navbar-nav user-menu">';
			$rc .= $this->theme->renderComponent($userMenu);
			$rc .= '</ul>';
		}
		return $rc;
	}

	public function setMenuStyle($key, $value) {
		$this->menuStyles[$key] = $value;
		return $this;
	}

	public function addStaticMenuConfig($line) {
		$this->staticMenuConfig[] = $line;
		return $this;
	}

	public function setMenuOptions($value) {
		$this->menuOptions = $value;
		return $this;
	}

	public function setMenuConfig($value) {
		$this->menuConfig = $value;
		return $this;
	}

	protected function renderMmenu() {
		$rc = '';
		if ($this->hasMenu) {
			$rc  = '<div id="mmenu"><ul>';
			foreach ($this->menu as $item) {
				$rc .= $this->renderMenuItem($item, 0);
			}
			$rc .= '</ul></div>';
		}
		return $rc;
	}

	protected function renderMenuItem($item, $level) {
		$rc = '';
		if ($item != NULL) {
			$rc = '<li>';
			$link = $item->getPageLink();
			if ($level == 0) {
				$icon = $item->getIcon();
				if ($icon == NULL) $icon = '';
				$icon = '<span class="mmenu-icon">'.$icon.'</span>';
			}

			if ($link != NULL) {
				$rc .= '<a href="'.htmlentities($link).'">'.$icon.$item->getLabel().'</a>';
			} else {
				$rc .= '<span>'.$icon.$item->getLabel().'</span>';
			}
			if ($item->hasChildren()) {
				$rc .= '<ul>';
				foreach ($item->getChildren() AS $child) {
					$rc .= $this->renderMenuItem($child, $level+1);
				}
				$rc .= '</ul>';
			}
			$rc .= '</li>';
		}
		return $rc;
	}

	protected function renderJavascript() {
		$rc = parent::renderJavascript();
		if ($this->hasMenu) {
			$rc .= '<script src="'.Utils::getWebRootPath(TRUE).'/mmenu/mmenu.js"></script>'.
			       $this->renderMenuStyles().
			       '<script type="text/javascript">'.
			          $this->renderStaticMenuConfig().
			          $this->renderMenuScript().
			       '</script>';
		}
		return $rc;
	}

	protected function renderMenuStyles() {
		$rc = '';
		if (count($this->menuStyles) > 0) {
			$rc  = '<style>.mm-menu{';
			foreach ($this->menuStyles AS $key => $value) {
				$rc .= $key.':'.$value.';';
			}
			$rc .= '}</style>';
		}
		return $rc;
	}

	protected function renderStaticMenuConfig() {
		return implode('', $this->staticMenuConfig);
	}

	protected function renderMenuScript() {
		$rc = 
			'document.addEventListener('.
				'"DOMContentLoaded", () => {'.
					'new Mmenu("#mmenu"'.
			$this->renderMenuOptions().
			$this->renderMenuConfig().
					');'.
				'}'.
			');';
		return $rc;
	}

	protected function renderMenuOptions() {
		$rc = '';
		if ($this->menuOptions != NULL) {
			if (is_string($this->menuOptions)) $rc .= ','.$this->menuOptions;
			else $rc .= ','.json_encode($this->menuOptions);
		} 
		return $rc;
	}

	protected function renderMenuConfig() {
		$rc = '';
		if ($this->menuConfig != NULL) {
			if ($this->menuOptions == NULL) $rc .= ',{}';
			if (is_string($this->menuConfig)) $rc .= ','.$this->menuConfig;
			else $rc .= ','.json_encode($this->menuConfig);
		}
		return $rc;
	}
}

