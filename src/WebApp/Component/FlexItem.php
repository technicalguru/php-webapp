<?php

namespace WebApp\Component;

class FlexItem extends Div {

	public function __construct($parent, $content = NULL) {
		parent::__construct($parent, $content);
		$this->addClass('flex-item');
	}

}

