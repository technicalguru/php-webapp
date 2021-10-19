<?php

namespace WebApp\Builder;

/** Descendants only need to declare methods like getViewLink(), getEditLink() etc. */
class AbstractLinkBuilder implements \TgUtils\LinkBuilder {

	public function __construct($app) {
		$this->app = $app;
	}

	public function getLink($subject, $action = \TgUtils\LinkBuilder::VIEW, $params = NULL) {
		if ($action == '') return '#'; // To break unwanted loops
		$methodName = 'get'.ucfirst($action).'Link';
		if (method_exists($this, $methodName)) {
			return call_user_func(array($this, $methodName), $subject, $params);
		}
		return '#';
	}
}

