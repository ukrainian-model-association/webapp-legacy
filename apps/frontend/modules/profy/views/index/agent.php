<?php

$au          = db::get_row(
        'select * from agency_user join agency a on a.id = agency_user.agency_id where user_id = :user_id',
        ['user_id' => $item['user_id']]
);

$agencyName  = static function ($au) {
    if (!$au) {
        return '';
    }

    return sprintf(', <a class="btn-link" href="/agency?id=%s">%s</a>', $au['id'], $au['name']);
};
$jobPosition = static function ($position) {
    switch ($position) {
        case 1:
            return ', Директор';
        case 2:
            return ', Букер';
        case 3:
            return ', Международный букер';
        case 4:
            return ', Скаут';
        default:
            return '';
    }
};

$location = static function($au) {
    if(!$au['country'] || !$au['city']){
        return '';
    }

    $country     = db::get_cols('select name_ru from countries where country_id = :id', ['id' => $au['country']]);
    $city        = db::get_cols('select name_ru from cities where city_id = :id', ['id' => $au['city']]);

    return <<<HTML
, {$city[0]} / {$country[0]}
HTML;
}

?>
<div>
<a class="font-weight-bold" href="/profile?id=<?= $item['user_id'] ?>"><?= sprintf(
            '%s %s',
            $item['first_name'],
            $item['last_name']
    ) ?></a><span class="text-muted"><?= $jobPosition($au['job_position']) ?><?= $agencyName($au) ?><?=$location($au)?></span>
</div>