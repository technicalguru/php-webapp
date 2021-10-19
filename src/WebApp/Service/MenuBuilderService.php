<?php

namespace WebApp\Service;

class MenuBuilderService extends AbstractService implements \WebApp\Builder\MenuBuilder {

	protected $builders;

	public function __construct($app) {
		parent::__construct($app);
		$this->builders = array();
	}

	public function getMenu($subject, $params = NULL) {
		$builder = $this->getBuilder($subject);
		if ($builder != NULL) {
			return $builder->getMenu($subject, $params);
		}
		return NULL;
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
			if ($pos = strrpos($name, '\\')) {
				$name = substr($name, $pos + 1);
			}
		}
		return $name;
	}

}

		
