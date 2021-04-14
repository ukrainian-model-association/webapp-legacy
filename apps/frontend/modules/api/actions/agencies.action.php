<?php

load::app('modules/api/controller');

load::model('agency');

/**
 * Class api_agencies_action
 *
 * @property array $json
 */
class api_agencies_action extends api_controller
{
    public function getRoutes()
    {
        return [
            '/^\/api\/agencies\/countries\/(?P<country>(\d+))\/cities/' => [[$this, 'getCities'], ['country']],
            '/^\/api\/agencies/'                                        => [[$this, 'findBy'], []],
        ];
    }

    /**
     * @return array
     */
    protected function findBy()
    {
        $findBy = request::get_array('find_by');

        return array_map(
            static function ($id) {
                return agency_peer::instance()->get_item($id);
            },
            agency_peer::instance()->get_list($findBy, [], ['name ASC'])
        );
    }

    protected function getCities($country)
    {

    }
}
