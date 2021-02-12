<?php

namespace WebApp\BootstrapTheme;

class LoginFormRenderer extends \WebApp\DefaultTheme\DivRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		$this->addClass('card');
		if (!$this->component->getHeader()->hasChildren()) {
			$this->component->removeChild($this->component->getHeader());
		} else {
			$this->component->getHeader()->addClass('card-header');
		}
		$this->component->getBody()->addClass('card-body');
		$this->component->getForm()->setAnnotation('horizontal-form/component-size', 'sm-12 md-6 lg-3');
		if (!$this->component->getFooter()->hasChildren()) {
			$this->component->removeChild($this->component->getFooter());
		} else {
			$this->component->getFooter()->addClass('card-footer');
		}
		if ($this->component->hasSocialLogins()) {
			$label = new \WebApp\Component\Text(NULL, \TgI18n\I18N::_('or_label'));
			$label->addClass('social-logins-label');
			$this->component->getSocialLogins()->addChildAt($label, 0);
		}
	}
}

