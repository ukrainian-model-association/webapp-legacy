<?php

/**
 * @param array                           $ctx
 * @param ServiceContainer $di
 *
 * @return null|string
 */

use App\Component\ServiceContainer;
use App\Component\UI\UI;

return static function ($ctx, $di) {
    $profile      = $ctx['profile'];
    $chronologies = $ctx['chronologies'];
    /** @var UI $ui */
    $ui = $di->get('ui');

    if (
        empty($chronologies) ||
        session::get_user_id() === 4
        // || profile_peer::MODEL_TYPE !== profile_peer::get_type_by_user($profile['user_id'])
    ) {
        return null;
    }

    $list = implode(
        PHP_EOL,
        array_map(
            static function ($item) {
                if (empty($item['name'])) {
                    return null;
                }

                $date = '-';
                if ($item['month'] > 0 && $item['year'] > 0) {
                    $date = sprintf('%s, %s', ui_helper::get_mounth_list($item['month']), $item['year']);
                }

                return <<<HTML
<li class="list-group-item px-0 py-1 d-flex flex-row justify-content-between">
    <span>{$item['category']} :: <a href='{$item['link']}'>{$item['name']}</a></span>
    <span>{$date}</span>
</li>
HTML;
            },
            $chronologies
        )
    );

    return $ui->render('layout/panel', [
        'title'   => 'Работы',
        'content' => sprintf('<ul class="list-group list-group-flush fs12">%s</ul>', $list),
    ], [
        'class' => 'mt-4',
    ]);
};
