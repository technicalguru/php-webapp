<?php

namespace WebApp\Component;

/** Component that has a special method that will be called immediately before rendering */
interface LazyInitializer {

	public function lazyInit();
}
