<?php

namespace WebApp\BootstrapTheme;

class DateTimeInputRenderer extends \WebApp\DefaultTheme\InputRenderer {

	public function __construct($theme, $component) {
		parent::__construct($theme, $component);
		//$this->theme->addFeature(BootstrapTheme::DATEPICKER);
		//$this->addClass('datepicker');
	}

	public function render() {
		$date  = $this->component->getDate();
		$time  = $this->component->getTime();
		$name  = $this->component->getName();
		$error = $this->component->getError();

		// Date
		$this->component->setValue($date);
		$this->component->setName($name.'-date');
		$this->component->setType('date');
		$rc  = '<div class="input-group">'.
		          '<div class="input-group-prepend">'.
		             '<span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>'.
		          '</div>'.
		          $this->renderStartTag('input');

		// Time
		$this->component->setValue($time);
		$this->component->setName($name.'-time');
		$this->component->setId($name.'-time');
		//$this->removeClass('datepicker');
		$this->component->setType('time');
		$rc .= $this->renderStartTag('input');

		// Error must go here
		if ($error != NULL) {
			$rc .= '<div id="validationFeedback-'.$name.'" class="invalid-feedback">'.$error.'</div>';
			$this->component->setError(NULL); // Do not render again
		}
		$rc .= '</div>';

		return $rc;
	}
}
