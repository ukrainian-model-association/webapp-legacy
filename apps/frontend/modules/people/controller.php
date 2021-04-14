<?php

use Symfony\Component\HttpFoundation\Request;

load::action_helper('pager');

load::model("geo");
load::model("user/profile");

abstract class people_controller extends frontend_controller
{
    public function execute()
    {
        $list = db::get_rows("SELECT user_id, rank FROM user_data WHERE rank = 0");
        if (!empty($list)) {
            foreach ($list as $id => $user) {
                db::exec("UPDATE user_data SET rank = ((SELECT MAX(rank) FROM user_data)+1) WHERE user_id=:uid", ['uid' => $user['user_id']]);
            }
        }
    }

    /**
     * @param Request $request
     */
    protected function handleRequest($request)
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            if (true !== $route($request)) {
                continue;
            }

            break;
        }
    }

    abstract protected function getRoutes();
}
