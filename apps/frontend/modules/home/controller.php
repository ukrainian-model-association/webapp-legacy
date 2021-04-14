<?php

/**
 * @property mixed options
 */
abstract class home_controller extends frontend_controller
{
	public function __construct()
	{
		parent::__construct('home', 'index');
	}

	public function execute()
	{
		$this->options = request::get_all();
	}
}
