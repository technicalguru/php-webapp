<?php

namespace WebApp\Email;

use \TgI18n\I18N;

class NiceButtonSnippet extends AbstractSnippet {

	public function __construct() {
		$this->bgColor = '#05164D';
		$this->fgColor = '#ffffff';
	}

	protected function getHtml($processor, $params) {
		$language = $processor->language;
		$bgColor  = $this->bgColor;
		$fgColor  = $this->fgColor;
		$link     = $processor->getObject($params[0]);
		$label    = I18N::_($params[1], $language);
		$rc = <<<EOT
<table cellspacing="0" cellpadding="0" style="display:inline-table">
   <tbody><tr>
      <td style="border-radius: 2px; margin-top: 1em; margin-bottom: 1em;" bgcolor="$bgColor">
         <a href="$link" target="_blank" style="padding: 10px 10px; border: 1px solid $bgColor; border-radius: 2px; font-family: Nunito,sans-serif; font-size: 1rem; color: $fgColor; text-decoration: none; font-weight: 700; display: inline-block;">$label</a>
      </td>
      </tr></tbody>
</table>
EOT;
		return $rc;
	}

	protected function getText($processor, $params) {
		$link     = $processor->getObject($params[0]);
		return '    '.$link;
	}
}
