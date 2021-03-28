<?php

namespace WebApp\Component;

class MainContent extends Div {

	public function __construct($parent, $child = NULL, $renderMessages = TRUE, $renderBreadcrumbs = TRUE) {
		parent::__construct($parent, $child);
		$this->addClass('content-main');
		if ($renderBreadcrumbs) {
			$this->createBreadcrumbs();
		}
		if ($renderMessages) {
			$msg = new SystemMessages($this);
			$msg->addClass('mb-4', 'mt-4');
		}
	}

	protected function createBreadcrumbs() {
		$page = $this->getPageParent();
		if ($page != NULL) {
			$breadcrumbs = $page->getBreadcrumbs();
			if (count($breadcrumbs) > 0) {
				$nav = new \WebApp\Component\Breadcrumb($this);
				foreach ($breadcrumbs AS $breadcrumb) {
					$nav->addChild($breadcrumb);
				}
			}
		}
	}

	
}

