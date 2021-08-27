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
		$rc  = '<link rel="stylesheet" href="'.$webroot.FontAwesome::getUri().'" type="text/css">'.
		       '<link rel="stylesheet" href="'.$this->getBootstrapUri().'" type="text/css">';
		if ($this->theme->hasFeature(BootstrapTheme::DATEPICKER)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('bootstrap-datepicker.min.css', TRUE).'" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::MULTISELECT)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('filter-multi-select.css', TRUE).'" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::FILEUPLOAD)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('bootstrap-datepicker.min.css', TRUE).'" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::MULTIIMAGEUPLOAD) || $this->theme->hasFeature(BootstrapTheme::IMAGEUPLOAD)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('multi-image-upload.css', TRUE).'" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::REMOTESEARCH)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('remote-search.css', TRUE).'" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DYNAMICFIELDS)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('dynamic-fields.css', TRUE).'" type="text/css">';
		}
		if ($this->theme->hasFeature(BootstrapTheme::CROPPERJS)) {
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('cropper/cropper.min.css', TRUE).'" type="text/css">';
			$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('cropper/cropper-ui.css', TRUE).'" type="text/css">';
		}
		$rc .= '<link rel="stylesheet" href="'.Utils::getCssPath('bootstrap.css', TRUE).'" type="text/css">';
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
		$rc = '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="'.I18N::_('navbar_toggle_label').'"><span class="navbar-toggler-icon"></span></button>';
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

		$rc .= '</div>';
		return $rc;
	}

	protected function renderContent() {
		$rc = '<div class="page-content container-fluid">'.
					$this->renderBrowserNotSupported().
		            $this->theme->renderComponent($this->page->getMain()).
		      '</div>';
		return $rc;
	}

	protected function renderBrowserNotSupported() {
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if ((strpos($userAgent, 'MSIE') > 0) || (strpos($userAgent, 'Trident') > 0)) {
			return '<div class="alert alert-danger m-3" id="browserNotSupported"><h4>'.I18N::_('browser_not_supported').'</h4><hr><p class="mb-0">'.I18N::_('use_these_browsers').'</p></div>';
		}
		return '';
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
		$rc =  '<script src="'.Utils::getJavascriptBasePath(TRUE).'/jquery-3.5.1.js"></script>'.
		       '<script src="'.$webroot.Bootstrap::getJsUri().'"></script>'.
		       '<script src="'.Utils::getJavascriptPath('webapp.js', TRUE).'"></script>'.
		       '<script src="'.Utils::getJavascriptPath('utils.js', TRUE).'"></script>';
		if ($this->theme->hasFeature(BootstrapTheme::MULTISELECT)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('filter-multi-select.bundle.js', TRUE).'"></script>'.
			       '<script>$(function() {$(\'.multiselect\').filterMultiSelect();});</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::FILEUPLOAD)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('bs-custom-file-input.min.js', TRUE).'"></script>'.
			       '<script>jQuery(document).ready(function () { bsCustomFileInput.init() })</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::MULTIIMAGEUPLOAD)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('multi-image-upload.js', TRUE).'"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::IMAGEUPLOAD)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('image-upload.js', TRUE).'"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DATEPICKER)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('bootstrap-datepicker.js', TRUE).'"></script>'.
			       '<script src="'.Utils::getJavascriptPath('bootstrap-datepicker-locales.min.js', TRUE).'"></script>'.
			       '<script>jQuery(document).ready(function () { $(\'.datepicker\').datepicker({ format: \''.I18N::_('datepicker_format').'\'}) })</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::TABS)) {
			$rc .= '<script type="text/javascript">jQuery(document).on(\'click\', \'ul.nav-tabs a\', function(e) { e.preventDefault(); jQuery(this).tab(\'show\').parent().addClass(\'active\'); jQuery(this).parent().siblings().removeClass(\'active\');});</script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::REMOTESEARCH)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('remote-search.js', TRUE).'"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::SEARCH_FILTER)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('search-filter.js', TRUE).'"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DYNAMICFIELDS)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('dynamic-fields.js', TRUE).'"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::DYNAMICCHECKENABLE)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('dynamic-check-enable.js', TRUE).'"></script>';
		}
		if ($this->theme->hasFeature(BootstrapTheme::CROPPERJS)) {
			$rc .= '<script src="'.Utils::getJavascriptPath('cropper/cropper.js', TRUE).'"></script>';
			$rc .= '<script src="'.Utils::getJavascriptPath('cropper/jquery-cropper.js', TRUE).'"></script>';
			$rc .= '<script src="'.Utils::getJavascriptPath('cropper/cropper-ui.js', TRUE).'"></script>';
		}
		$rc .= parent::renderJavascript();
		return $rc;
	}

}

