<?php

namespace WebApp\DataModel;

class Session {

	public $uid;
	public $creation_time;
	public $update_time;
	public $expiry_time;
	public $data;
	public $persistent;

	public function __construct() {
	}

}
