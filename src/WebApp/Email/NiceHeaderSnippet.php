<?php

namespace WebApp\Email;

class NiceHeaderSnippet extends AbstractSnippet {

	protected function getHtml($processor) {
		return '<html><head></head><body>';
	}

	protected function getText($processor) {
		return '';
	}

}
