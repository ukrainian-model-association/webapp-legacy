<?php

load::app('modules/api/controller');

load::model('journals/journals');

class api_journals_action extends api_controller
{

    /**
     * @inheritDoc
     */
    public function getRoutes()
    {
        return [
            '/^\/api\/journals/' => [[$this, 'findBy'], []],
        ];
    }

    public function findBy()
    {
        $request = request::get_all();
        
        return journals_peer::instance()->findByCountry($request['country']);
    }
}