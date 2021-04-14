<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

use App\Component\WorkAlbum\Controller\WorkController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

load::app('modules/api/controller');

load::model('user/user_agency');
load::model('user/user_foreign_works');
load::model('agency');

/**
 * Class api_profiles_action
 */
class api_profiles_action extends api_controller
{
    /**
     * @return array
     */
    public function getRoutes()
    {
        return [
            '/^\/api\/profiles\/(?P<id>\d+)\/agencies.*/'                        => [
                function ($id) {
                    return $this->updateProfileAgencies((int) $id);
                },
                ['id'],
            ],
            '/^\/api\/profiles\/(?P<id>\d+)\/milestones.*/'                      => [
                function ($id) {
                    return $this->setProfileMilestone((int) $id);
                },
                ['id'],
            ],
            '/^\/api\/profiles\/(?P<id>\d+)\/extra.*/'                           => [
                function ($id) {
                    $target = \request::get_string('target');
                    $value  = \request::get_string('value');

                    switch (true) {
                        case $target === 'successful_model':
                            return $this->setSuccessfulModel($id, (bool) $value);

                        case $target === 'member_of_association':
                            return $this->setMemberOfAssociation($id, (bool) $value);

                        default:
                            return null;
                    }
                },
                ['id'],
            ],
            '/^\/api\/profiles\/(?P<profileId>\d+)\/works\/(?P<workId>[\w\d]+)/' => [
                static function ($profileId, $workId, $request) {
                    $controller = new WorkController($request);

                    switch ($request->getMethod()) {
                        case Request::METHOD_GET:
                            return $controller->getWorkAlbum($profileId, $workId);

                        case Request::METHOD_POST:
                            return $controller->createOrEditAlbum($profileId, $workId);

                        case Request::METHOD_DELETE:
                            return $controller->deleteAlbum($profileId, $workId);

                        default:
                            return null;
                    }
                },
                ['profileId', 'workId'],
            ],
            '/^\/api\/profiles\/(?P<profileId>\d+)\/foreign-works\/(?P<id>\d+)/' => [
                function ($id, $profileId) {
                    switch ($_SERVER['REQUEST_METHOD']) {
                        case 'POST':
                            return $this->createForeignWork(request::get_array('foreign_work'));

                        case 'GET':
                            return $this->getForeignWorkById($id);

                        case 'DELETE':
                            return $this->deleteForeignWork($id);

                        case 'PUT':
                            return $this->updateForeignWork($id, \request::get_array('foreign_work'));

                        default:
                            return null;
                    }
                },
                ['id', 'profileId'],
            ],
            '/^\/api\/profiles\/(?P<profileId>\d+)\/foreign-works/'              => [
                function ($profileId) {
                    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                        return false;
                    }

                    return $this->createForeignWork($_REQUEST['foreign_work']);
                },
                ['profileId'],
            ],
        ];
    }

    private function updateProfileAgencies($id)
    {
        $aid  = user_agency_peer::instance()->getAgencyByUser($id);
        $uua  = \request::get_array('uua');
        $ufa  = \request::get_array('ufa');
        $maid = (int) \request::get_array('mother_agency', [-7])[0];

        user_agency_peer::instance()->saveAgency(
            $aid,
            [
                'user_id'        => $id,
                'agency_id'      => $uua['id'],
                'name'           => $uua['name'],
                'city'           => '',
                'foreign_agency' => false,
                'contract_type'  => $uua['contract_type'],
                'type'           => $maid === -1 ? 1 : 0,
                'contract'       => $uua['contract'],
                'country_id'     => geo_peer::UKRAINE,
                'region_id'      => null,
                'city_id'        => $uua['city'],
                'profile'        => !empty($uua['profile']) ? $uua['profile'] : null,
            ]
        );

        array_map(
            static function ($id) {
                user_agency_peer::instance()->delete_item($id);
            },
            user_agency_peer::instance()->get_list(
                [
                    'user_id'        => $id,
                    'foreign_agency' => true,
                ]
            )
        );

        array_map(
            static function ($key, $ufa) use ($id, $maid) {
                user_agency_peer::instance()->insert(
                    [
                        'user_id'        => $id,
                        'agency_id'      => $ufa['id'],
                        'name'           => $ufa['name'],
                        'city'           => '',
                        'foreign_agency' => true,
                        'type'           => $maid === (int) $key ? 1 : 0,
                        'country_id'     => $ufa['country'],
                        'region_id'      => null,
                        'city_id'        => $ufa['city'],
                        'profile'        => $ufa['profile'],
                    ]
                );
            },
            array_keys($ufa),
            array_values($ufa)
        );

        return null;
    }

    private function setProfileMilestone($profileId)
    {
        $value = \request::get_int('milestone');

        profile_peer::instance()
            ->useContext(user_auth_peer::instance()->get_item($profileId))
            ->setMilestone($value);

        return true;
    }

    private function setSuccessfulModel($id, $value)
    {
        user_auth_peer::instance()->update(
            [
                'id'               => $id,
                'successful_model' => $value,
            ]
        );

        return true;
    }

    public function setMemberOfAssociation($id, $value)
    {
        user_auth_peer::instance()->update(
            [
                'id'                    => $id,
                'member_of_association' => $value,
            ]
        );

        return true;
    }

    public function createForeignWork($data)
    {
        $agencyId = $data['agency_id'];
        $agency   = agency_peer::instance()->get_item($agencyId);

        $fw = [
            'user_id'          => $data['user_id'],
            'country'          => $data['country'],
            'city'             => $data['city'],
            'from_ts'          => DateTime::createFromFormat('Y-m-d', "{$data['from_year']}-{$data['from_month']}-01")->format('Y-m-d H:i:s'),
            'to_ts'            => DateTime::createFromFormat('Y-m-d', "{$data['to_year']}-{$data['to_month']}-01")->format('Y-m-d H:i:s'),
            'work_description' => $data['description'],
            'agency_id'        => $agencyId,
            'company_name'     => $agency['name'],
        ];

        return user_foreign_works::instance()->insert($fw);
    }

    public function getForeignWorkById($id)
    {
        return user_foreign_works::instance()->get_item($id);
    }

    public function deleteForeignWork($id)
    {
        user_foreign_works::instance()->delete_item($id);

        return true;
    }

    public function updateForeignWork($id, $data)
    {
        $agencyId = $data['agency_id'];
        $agency   = agency_peer::instance()->get_item($agencyId);

        $fw = [
            'id'               => $id,
            'user_id'          => $data['user_id'],
            'country'          => $data['country'],
            'city'             => $data['city'],
            'from_ts'          => $data['from_ts'],
            'to_ts'            => $data['to_ts'],
            'work_description' => $data['description'],
            'agency_id'        => $agencyId,
            'company_name'     => $agency['name'],
        ];

        user_foreign_works::instance()->update($fw);
    }
}
