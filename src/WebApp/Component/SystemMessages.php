<?php

namespace WebApp\Component;

use TgLog\Log;

class SystemMessages extends Div {

	public function __construct($parent) {
		parent::__construct($parent);
		$this->addClass('system-messages');
		$this->addMessages();
	}

	protected function addMessages() {
		$messages = Log::get();
		if (is_array($messages)) {
			foreach ($messages AS $message) {
				$this->addMessage($message);
			}
		}
		Log::clean();
	}

	protected function addMessage($message) {
		switch ($message->getType()) {
		case 'error':   $rc = new Alert($this, Alert::ERROR,   NULL, $message->getMessage()); break;
		case 'warning': $rc = new Alert($this, Alert::WARNING, NULL, $message->getMessage()); break;
		case 'info':    $rc = new Alert($this, Alert::INFO,    NULL, $message->getMessage()); break;
		case 'success': $rc = new Alert($this, Alert::SUCCESS, NULL, $message->getMessage()); break;
		}
		return $rc;
	}
}

