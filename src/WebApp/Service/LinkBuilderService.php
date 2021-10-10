<?php

namespace WebApp\Service;

class LinkBuilderService extends AbstractService {

	public function __construct($app) {
		parent::__construct($app);
		$this->builders = array();
	}

	public function getLink($subject, $action = LinkBuilder::VIEW, $params = NULL) {
		$builder = $this->getBuilder($subject);
		if ($builder != NULL) {
			return $builder->getLink($subject, $action, $params);
		}
		return '#';
	}

	public function getBuilder($subject) {
		$name = $this->getBuilderName($subject);
		if (!isset($this->builders[$name])) {
			$this->builders[$name] = $this->createBuilder($name);
		}
		return $this->builders[$name];
	}

	protected function createBuilder($name) {
		return NULL;
	}

	protected function getBuilderName($subject) {
		$name = NULL;
		if (is_string($subject)) {
			$name = $subject;
		} else if (is_object($subject)) {
			$name = strtolower(get_class($subject));
		}
		return $name;
	}

}
