<?php

namespace WebApp\Component;

interface SingleValueComponent {

	public function getValue();
	public function setValue($value);
}
