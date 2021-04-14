<?php

load::app('modules/journals/controller');
load::model('journals/journals');
load::model('user/profile');

class journals_list_action extends journals_controller
{
	public function execute()
	{
		parent::execute();

		$this->countries = [
			9908   => [],
			3159   => [],
			10668  => [],
			1786   => [],
			5681   => [],
			277565 => [],
			582040 => [],
			1012   => [],
			1707   => [],
			3141   => [],
			1258   => [],
			277563 => [],
			582050 => [],
			277555 => [],
			277559 => [],
		];

		$this->journals_list = journals_peer::instance()->get_list(['public' => true], [], ['name ASC']);

		foreach ($this->journals_list as $id) {
			$country                     = journals_peer::instance()->get_item_country($id);
			$this->countries[$country][] = $id;
		}
	}
}
