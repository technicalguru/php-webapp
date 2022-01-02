<?php

namespace WebApp\Component;

abstract class FormCheckGroup extends CombinedFormElement {

	public function __construct($parent, $id, $values = NULL) {
		parent::__construct($parent, $id, $values);
	}

}
