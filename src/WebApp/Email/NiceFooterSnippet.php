<?php

namespace WebApp\Email;

class NiceFooterSnippet extends AbstractSnippet {

	protected function getHtml($processor) {
		return '</body></html>';
	}

	protected function getText($processor) {
		return '';
	}

}
