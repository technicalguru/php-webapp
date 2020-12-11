<?php

namespace WebApp\BootstrapTheme;

use TgI18n\I18N;
use TgFontAwesome\FontAwesome;
use TgBootstrap\Bootstrap;
use TgJQuery\JQuery;
use WebApp\Utils;

/** A basic layout at all */
class DefaultLayout extends \WebApp\Layout {

	public function __construct($theme, $page) {
		parent::__construct($theme, $page);
	}

	protected function renderLinks() {
		$rc  = '<link rel="stylesheet" href="'.FontAwesome::getUri().'" rel="stylesheet" type="text/css">'.
		       Bootstrap::getCssLink().
		      '<link rel="stylesheet" href="'.Utils::getCssBaseUrl(TRUE).'/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">';
		$rc .= parent::renderLinks();
		return $rc;
	}

	protected function renderBody() {
		$rc = '<body>'.
		      $this->renderNavbar().
		      $this->renderContent().
		      $this->renderJavascript().
		      '</body>';
		return $rc;
	}

	protected function renderNavbar() {
		$rc = '<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">'.
		         $this->renderNavbarBrand().
		         $this->renderNavbarToggler().
		         $this->renderNavbarContent().
		      '</nav>';
		return $rc;
	}

	protected function renderNavbarBrand() {
		$rc  = '<span class="navbar-brand mb-0 display-4">';
		$link = $this->app->getBrandLink();
		if ($link == null) $link = \WebApp\Utils::getAppPath('/');
		if ($link != null) $rc .= '<a class="navbar-brand" href="'.$link.'">';
		$logo = $this->app->getBrandLogo();
		if ($logo != null) {
			if ((substr($logo, 0, 4) != 'http') && (substr($logo, 0, 1) != '/')) $logo = Utils::getImageBaseUrl().'/'.$logo;
			$size = $this->app->getBrandSize() != NULL ? $this->app->getBrandSize() : 30;
			$rc .= '<img src="'.$logo.'" style="margin-right: 10px;" alt="" loading="lazy" width="'.$size.'" height="'.$size.'">';
		}
		$rc .= $this->app->getBrandName();
		if ($link != null) $rc .= '</a>';
		$rc .= '</span>';
		return $rc;
	}

	protected function renderNavbarToggler() {
		$rc = '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbarContent" aria-expanded="false" aria-label="'.I18N::_('navbar_toggle_label').'"><span class="navbar-toggler-icon"></span></button>';
		return $rc;
	}

	protected function renderNavbarContent() {
		$rc   = '<div id="navbar-content" class="collapse navbar-collapse">'.
		          '<ul class="navbar-nav mr-auto main-menu">';
		$menu = $this->app->getMenu();
		if (($menu != NULL) && is_array($menu)) {
			foreach ($menu AS $menuItem) {
				$rc .= $this->theme->renderComponent($menuItem);
			}
		}
		$rc  .=    '</ul>';
		$principal = $this->app->getPrincipal();
		if ($principal != NULL) {
			$rc .= '<ul class="navbar-nav user-menu">';
			$userMenu = $this->app->getMenu('user');
			if ($userMenu == NULL) {
				$userMenu = array();
				$userItem = new \WebApp\Component\MenuItem($this, $principal->__toString(), '#');
				$userMenu[] = new \WebApp\Component\MenuItem($userItem, 'logout_label', '?logout');
				$userMenu = array($userItem);
			}
			if (($userMenu != NULL) && is_array($userMenu)) {
				//$userMenu[] = new \WebApp\Component\MenuItem($this, 'logout_label', '?logout');
				foreach ($userMenu AS $menuItem) {
					$rc .= $this->theme->renderComponent($menuItem);
				}
				
			}
			//$rc .= '<span class="navbar-text align-middle">'.$principal->__toString().'<a class="px-2" href="?logout"><i class="fas fa-sign-out-alt fa-lg"></i></a></span>';
			$rc  .= '</ul>';
		} else if ($this->app->getPageLink('login') != NULL) {
			$uri   = $this->app->request->uri;
			$login = Utils::getAppPath($this->app->getPageLink('login'));
			if ($this->app->request->path == $login) {
				$uri = $this->app->request->path;
			} else {
				$uri = $login.'?return='.urlencode($this->app->request->uri);
			}
			$rc .= '<span class="navbar-text  align-middle"><a class="px-2" href="'.$uri.'">'.I18N::_('login_label').'</a></span>';
		}
		$rc .= '</nav>';
		return $rc;
	}

	protected function renderContent() {
		$rc = '<div class="pageContent">'.
		         '<div class="container">'.
		            $this->theme->renderComponent($this->page->getMain()).
		            $this->theme->renderComponent($this->renderLog()).
		         '</div>'.
		      '</div>';
		return $rc;
	}

	protected function renderJavascript() {
		$rc = JQuery::getLink('3.5.1', JQuery::MINIFIED).
		       '<script src="'.Bootstrap::getJsUri().'"></script>'.
		       '<script src="'.Utils::getJavascriptBaseUrl(TRUE).'/webapp.js"></script>'.
		       '<script src="'.Utils::getJavascriptBaseUrl(TRUE).'/utils.js"></script>';
		$rc .= parent::renderJavascript();
		return $rc;
	}

	protected function renderLog() {
		$rc = parent::renderLog();
		if ($rc) {
			$div = new \WebApp\Component\Div($this);
			$div->addClass('container-fluid');
			$div->setStyle('border-top', '1px solid #999');
			$div->setStyle('margin-top', '2em');
			$div->setStyle('padding-top', '1em');
			$div->addChild($rc);
			//'<div class="container-fluid" style="border-top: 1px solid #999;">'.$rc.'</div>';
			$rc = $div;
		}
		return $rc;
	}
}

