<?php

return static function ($ctx) {
    $profile = $ctx['profile'];
    $status  = [
        profile_peer::instance()
            ->useContext($profile)
            ->useStatusTypeCaptionMap(
                [
                    profile_peer::SUCCESSFUL_KEY => t('Успешная модель'),
                    // profile_peer::NEW_FACES_KEY   => t('Новое лицо'),
                    // profile_peer::PERSPECTIVE_KEY => t('Перспективная модель'),
                    profile_peer::LEGENDARY_KEY  => t('Одна из самых успешных моделей'),
                ]
            )
            ->getStatusTypeCaption(),
    ];

    $statusMap = [
        static function ($profile) use (&$status) {
            // if (0 !== (int) $profile['show_on_main']) {
            //     return;
            // }

            $status = [profile_peer::get_status($profile['type'], $profile['status'])];
        },
        // static function ($profile) use (&$status) {
        //     if (22 !== (int) $profile['status']) {
        //         return;
        //     }
        //
        //     $status[] = t('Член Ассоциации');
        // },
        // static function ($profile) use (&$status) {
        //     if (24 !== (int) $profile['status']) {
        //         return;
        //     }
        //
        //     $status[] = t('Кандидат в Члены Ассоциации');
        // },
    ];

    $agent = static function ($userId) {
        $wp = db::get_row(
            'select * from agency_user join agency a on a.id = agency_user.agency_id where user_id = :user_id',
            ['user_id' => $userId]
        );
        if (!$wp) {
            return '';
        }
        $country = db::get_cols('select name_ru from countries where country_id = :id', ['id' => $wp['country']]);
        $city    = db::get_cols('select name_ru from cities where city_id = :id', ['id' => $wp['city']]);

        $position = '';
        switch ($wp['job_position']) {
            case 1:
                $position = 'Директор';
                break;
            case 2:
                $position = 'Букер';
                break;
            case 3:
                $position = 'Международный букер';
                break;
            case 4:
                $position = 'Скаут';
                break;
        }

        return <<<HTML
<div class="mt-2" style="margin-bottom: -6px">
<a  class="font-weight-bold" href="/agency/?id={$wp['agency_id']}">{$wp['name']}</a>, {$position}
</div>
<span class="text-muted">{$city[0]} / {$country[0]}</span>
HTML;
    };

    $proffesional = static function ($userId) {
        $ud = user_data_peer::instance()->get_item($userId);

        if (!$ud['country'] || !$ud['region']) {
            return '';
        }

        $country = db::get_cols('select name_ru from countries where country_id = :id', ['id' => $ud['country']]);
        $city    = db::get_cols('select name_ru from regions where region_id = :id', ['id' => $ud['region']]);

        return <<<HTML
<span class="text-muted">{$city[0]} / {$country[0]}</span>
HTML;

    };

    array_map(
        static function ($fn) use ($profile) {
            $fn($profile);
        },
        $statusMap
    );

    $status = implode(', ', $status);

    return <<<HTML
<!-- START STATUS -->
<div class="font-weight-bold">
    {$status}
</div>
<div>
    {$agent($profile['user_id'])}
    {$proffesional($profile['user_id'])}
</div>
<!-- END STATUS -->
HTML;
};
