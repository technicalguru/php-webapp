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
		$webroot = $this->app->request->webRoot;
		$rc  = '<link rel="stylesheet" href="'.$webroot.FontAwesome::getUri().'" rel="stylesheet" type="text/css">'.
		       '<link rel="stylesheet" href="'.$webroot.Bootstrap::getCssUri().'" rel="stylesheet" type="text/css">'.
			   '<style>'.
				  '.dropdown-item.nav-link {'.
					 'padding: .25rem 1.5rem !important;'.
				  '}'.
				  '.navbar-dark .dropdown-item.nav-link:hover,'.
				  '.navbar-dark .dropdown-item.nav-link:active,'.
				  '.navbar-dark .dropdown-item.nav-link:focus {'.
					 'color: #333333 !important;'.
					 'background-color: #f8f9fa !important;'.
				  '}'.
			   '</style>';
		if ($this->theme->hasFeature(BootstrapTheme::DATEPICKER)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::MULTISELECT)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/filter-multi-select.css" rel="stylesheet" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::FILEUPLOAD)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::MULTIIMAGEUPLOAD) || $this->theme->hasFeature(BootstrapTheme::IMAGEUPLOAD)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/multi-image-upload.css" rel="stylesheet" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::REMOTESEARCH)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/remote-search.css" rel="stylesheet" type="text/css">';
		}
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
		if ($link == null) $link = $this->app->router->getCanonicalPath('/');
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
				$logoutLink = $this->app->getPageLink('logout');
				if ($logoutLink != NULL) $logoutLink = $this->app->router->getCanonicalPath($logoutLink);
				else                     $logoutLink = '';
				$userMenu[] = new \WebApp\Component\MenuItem($userItem, 'logout_label', $logoutLink.'?logout');
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
			$login = $this->app->router->getCanonicalPath($this->app->getPageLink('login'));
			if ($this->app->request->originalPath == $login) {
				$uri = $this->app->request->originalPath;
			} else {
				$uri = $login.'?return='.urlencode($this->app->request->originalPath);
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
		$webroot = $this->app->request->webRoot;
		$rc =  '<script src="'.$webroot.JQuery::getUri('3.5.1', JQuery::MINIFIED).'"></script>'.
		       '<script src="'.$webroot.Bootstrap::getJsUri().'"></script>'.
		       '<script src="'.Utils::getJavascriptBasePath(TRUE).'/webapp.js"></script>'.
		       '<script src="'.Utils::getJavascriptBasePath(TRUE).'/utils.js"></script>';
		if ($this->theme->hasFeature(BootstrapTheme::MULTISELECT)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/filter-multi-select.bundle.js"></script>'.
			       '<script>$(function() {$(\'.multiselect\').filterMultiSelect();});</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::FILEUPLOAD)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/bs-custom-file-input.min.js"></script>'.
			       '<script>jQuery(document).ready(function () { bsCustomFileInput.init() })</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::MULTIIMAGEUPLOAD)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/multi-image-upload.js"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::IMAGEUPLOAD)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/image-upload.js"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DATEPICKER)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/bootstrap-datepicker.js"></script>'.
			       '<script src="'.Utils::getJavascriptBasePath(TRUE).'/bootstrap-datepicker-locales.min.js"></script>'.
			       '<script>jQuery(document).ready(function () { $(\'.datepicker\').datepicker({ format: \''.I18N::_('datepicker_format').'\'}) })</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::TABS)) {
			$rc .= '<script type="text/javascript">$("ul.nav-tabs a").click(function (e) { e.preventDefault();  $(this).tab(\'show\');});</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::REMOTESEARCH)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/remote-search.js"></script>';
		}
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

