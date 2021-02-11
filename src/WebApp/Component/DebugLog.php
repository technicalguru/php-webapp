<?php

namespace WebApp\Component;

use TgLog\Log;

class DebugLog extends Container {

	public function __construct($parent) {
		parent::__construct($parent);
		new Heading($this, 4, 'Debug Log');

		$log = '';
		foreach (Log::instance()->messages AS $sev => $msgs) {
			foreach ($msgs AS $msg) {
				$log .= '['.strtoupper($sev).'] '.htmlspecialchars($msg)."\n";
			}
		}
		new Preformatted($this, $log);
	}
}

