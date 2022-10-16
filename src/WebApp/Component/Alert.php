<?php

namespace WebApp\Component;

use TgI18n\I18N;

class Alert extends Container {

	public const ERROR   = 'error';
	public const WARNING = 'warning';
	public const INFO    = 'info';
	public const SUCCESS = 'success';

	protected $type;
	protected $title;
	protected $description;

	public function __construct($parent, $type = Alert::ERROR, $title = '', $description = '') {
		parent::__construct($parent);
		$this->type        = $type;
		$this->title       = $title;
		$this->description = $description;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($value) {
		$this->type = $value;
	}

	public function getTitle() {
		return I18N::_($this->title);
	}

	public function setTitle($value) {
		$this->title = $value;
	}

	public function getDescription() {
		return I18N::_($this->description);
	}

	public function setDescription($value) {
		$this->description = $value;
	}

}

