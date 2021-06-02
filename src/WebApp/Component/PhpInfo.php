<?php

namespace WebApp\Component;

class PhpInfo extends Div {

	public function __construct($parent) {
		parent::__construct($parent);

		ob_start();
		phpinfo();
		$pinfo = ob_get_contents();
		ob_end_clean();
		$style = 
			'<style>'.
				'#phpinfo pre {margin: 0; font-family: monospace;}'.
				'#phpinfo a:link {color: #009; text-decoration: none; background-color: #fff;}'.
				'#phpinfo a:hover {text-decoration: underline;}'.
				'#phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc; margin: 1em; text-align: left;}'.
				'#phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}'.
				'#phpinfo th {position: sticky; top: 0; background: inherit;}'.
				'#phpinfo h1 {font-size: 150%; margin-left: 1em;}'.
				'#phpinfo h2 {font-size: 125%; margin-left: 1em;}'.
				'#phpinfo .p {text-align: left;}'.
				'#phpinfo .e {background-color: #ccf; width: 300px; font-weight: bold;}'.
				'#phpinfo .h {background-color: #99c; font-weight: bold;}'.
				'#phpinfo .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}'.
				'#phpinfo .v i {color: #999;}'.
				'#phpinfo img {float: right; border: 0;}'.
				'#phpinfo hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}'.
			'</style>';
		// Strip off original style and replace outer div
		$pinfo = '<div>'.substr($pinfo, strpos($pinfo, '<div class="center">')+20);
		$this->addChild($style.$pinfo);
		$this->setId('phpinfo');
	}
}

