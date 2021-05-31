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

	protected function getBootstrapUri() {
		return $this->page->getAnnotation(BootstrapTheme::CSS_URI, $webroot.Bootstrap::getCssUri());
	}

	protected function renderLinks() {
		$webroot = $this->app->request->webRoot;
		$rc  = '<link rel="stylesheet" href="'.$webroot.FontAwesome::getUri().'" rel="stylesheet" type="text/css">'.
		       '<link rel="stylesheet" href="'.$this->getBootstrapUri().'" rel="stylesheet" type="text/css">';
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
		if ($this->theme->hasFeature(BootstrapTheme::DYNAMICFIELDS)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/dynamic-fields.css" rel="stylesheet" type="text/css">';
		}
		$rc .= '<link rel="stylesheet" href="'.Utils::getCssBasePath(TRUE).'/bootstrap.css" rel="stylesheet" type="text/css">';
		$rc .= parent::renderLinks();
		return $rc;
	}

	protected function renderBody() {
		$rc = '<body lang="'.$this->app->request->language.'">'.
		         '<div class="full-page">'.
			       $this->renderNavbar().
			       $this->renderContent().
			       $this->renderFooter().
		         '</div>'.
			     $this->theme->renderComponent($this->renderLog()).
				 $this->renderJavascript().
		      '</body>';
		return $rc;
	}

	protected function renderNavbar() {
		$rc =  '<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">'.
		          $this->renderNavbarBrand();
		if (!$this->app->isMaintenance()) {
			$rc .= $this->renderNavbarToggler().
			       $this->renderNavbarContent();
		}
		$rc .= '</nav>';
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

		$userMenu = $this->app->getMenu('user');
		if ($userMenu == NULL) {
			$userMenu  = array();
			$principal = $this->app->getPrincipal();
			if ($principal != NULL) {
				$userItem = new \WebApp\Component\MenuItem($this, $principal->__toString(), '#');
				$logoutLink = $this->app->getPageLink('logout');
				if ($logoutLink != NULL) $logoutLink = $this->app->router->getCanonicalPath($logoutLink);
				else                     $logoutLink = '';
				$userMenu[] = new \WebApp\Component\MenuItem($userItem, 'logout_label', $logoutLink.'?logout');
				$userMenu = array($userItem);
			} else if ($this->app->getPageLink('login') != NULL) {
				$uri   = $this->app->request->uri;
				$login = $this->app->router->getCanonicalPath($this->app->getPageLink('login'));
				if ($this->app->request->originalPath == $login) {
					$uri = $this->app->request->originalPath;
				} else {
					$uri = $login.'?return='.urlencode($this->app->request->originalPath);
				}
				$userMenu[] = '<span class="navbar-text  align-middle"><a class="px-2" href="'.$uri.'">'.I18N::_('login_label').'</a></span>';
			}
		}			

		if ($userMenu != NULL) {
			$rc .= '<ul class="navbar-nav user-menu">';
			$rc .= $this->theme->renderComponent($userMenu);
			$rc .= '</ul>';
		}

		$rc .= '</nav>';
		return $rc;
	}

	protected function renderContent() {
		$rc = '<div class="page-content container-fluid">'.
		            $this->theme->renderComponent($this->page->getMain()).
		      '</div>';
		return $rc;
	}

	protected function renderFooter() {
		$footer = $this->app->getFooter();
		if (is_object($footer) || (is_array($footer) && count($footer) > 0) || is_string($footer)) {
			return '<footer>'.$this->theme->renderComponent($footer).'</footer>';
		}
		return '';
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
			$rc .= '<script type="text/javascript">jQuery(document).on(\'click\', \'ul.nav-tabs a\', function(e) { e.preventDefault(); jQuery(this).tab(\'show\').parent().addClass(\'active\'); jQuery(this).parent().siblings().removeClass(\'active\');});</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::REMOTESEARCH)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/remote-search.js"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DYNAMICFIELDS)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/dynamic-fields.js"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DYNAMICCHECKENABLE)) {
			$rc .= '<script src="'.Utils::getJavascriptBasePath(TRUE).'/dynamic-check-enable.js"></script>';
		}
		$rc .= parent::renderJavascript();
		return $rc;
	}

}

