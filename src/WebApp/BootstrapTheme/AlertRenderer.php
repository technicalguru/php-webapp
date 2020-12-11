<?php

namespace WebApp\BootstrapTheme;

use WebApp\Component\Alert;

class AlertRenderer extends \WebApp\DefaultTheme\AlertRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
	}

	public function render() {
		$this->addClass('alert');
		$this->addClass($this->getAlertType($this->component->getType()));
		$rc  = $this->renderStartTag('div');
		$title = $this->component->getTitle();
		$desc  = $this->component->getDescription();
		if ($title != NULL) {
			$rc .= '<h4>'.$title.'</h4>';
			if (($desc  != NULL) || $this->component->hasChildren()) {
				$rc .= '<hr>';
			}
		}
		if ($desc  != NULL) $rc .= '<p class="mb-0">'.$desc.'</p>';
		$rc .= $this->renderChildren().
		       $this->renderEndTag('div');
		return $rc;
	}

	protected function getAlertType($alertType) {
		switch ($alertType) {
		case Alert::ERROR:   return 'alert-danger';
		case Alert::WARNING: return 'alert-warning';
		case Alert::INFO:    return 'alert-info';
		case Alert::SUCCESS: return 'alert-success';
		}
		return 'alert-secondary';
	}
}

