<?php

namespace WebApp\BootstrapTheme\GridForm;

class RowWrapper extends \WebApp\Renderer {

	public function __construct($theme, $component, $builder, $wrapped) {
		parent::__construct($theme, $component);
		$this->builder = $builder;
		$this->wrapped = $wrapped;
	}

	public function startRow() {
		$rc = '';
		if ($this->component->getAnnotation('grid-form/new-row', FALSE) || !$this->builder->hasRow()) {
			if ($this->builder->hasRow()) {
				$rc .= '</div>';
				$rc = $this->builder->endRow();
			}
			$rc .= $this->builder->startRow();
		}
		return $rc;
	}

	public function render() {
		// Ensure a row
		$rc     = $this->startRow();
		$rc    .= $this->wrapped->render();
		return $rc;
	}
}
