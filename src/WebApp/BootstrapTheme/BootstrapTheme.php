<?php

namespace WebApp\BootstrapTheme;

/** A basic theme that has no layout at all */
class BootstrapTheme extends \WebApp\DefaultTheme\DefaultTheme {

	public const MULTISELECT = 'multiselect';
	public const DATEPICKER  = 'datepicker';

	public function __construct($app) {
		parent::__construct($app);
	}

}

