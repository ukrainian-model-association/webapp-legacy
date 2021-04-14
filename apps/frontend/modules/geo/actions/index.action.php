<?php

load::app('modules/geo/controller');

class geo_index_action extends geo_controller
{

    public function execute()
    {
        parent::execute();

        $act = request::get_string('act');

        switch ($act) {
            case 'get_cities':
                // $cond = ['region_id' => request::get_int('region_id')];
                //
                // if (!request::get_int('region_id')) {
                //     $cond = ['country_id' => request::get_int('country_id')];
                // }
                //
                // $options = [];
                // if (request::get_int('big_cities') > 0) {
                //     $options['big-cities'] = true;
                // }

                $this->json['cities'] = $this->getCities(request::get_int('country_id'));
                break;

            case 'get_regions':
                $cond                  = [
                    'country_id' => request::get_int('country_id'),
                ];
                $this->json['regions'] = geo_peer::instance()->get_regions($cond);
                break;

            case 'get_countries':
            default:
                $this->json['countries'] = geo_peer::instance()->get_countries($by);
                break;
        }
    }

    public function getCities($countryId, $regionId = null)
    {
        if (
            !array_key_exists($countryId, geo_peer::ALLOWED_CITY_IDS_BY_COUNTRY_ID)
            || !is_array(geo_peer::ALLOWED_CITY_IDS_BY_COUNTRY_ID[$countryId])
        ) {
            return [];
        }

        return db::get_rows(
            sprintf(
                'select *, name_ru as name from cities where country_id = :country_id and city_id in (%s) order by name_ru',
                implode(', ', geo_peer::ALLOWED_CITY_IDS_BY_COUNTRY_ID[$countryId])
            ),
            [
                'country_id' => $countryId,
            ]
        );


        // if (!request::get_int('region_id')) {
        //     $cond = ['country_id' => request::get_int('country_id')];
        // }
        //
        // $options = [];
        // if (request::get_int('big_cities') > 0) {
        //     $options['big-cities'] = true;
        // }
        //
        // $this->json['cities'] = geo_peer::instance()->get_cities($cond, $options);
    }

}
