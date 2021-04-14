<?php

/**
 * @param array                           $ctx
 * @param ServiceContainer $di
 *
 * @return string
 */

use App\Component\ServiceContainer;
use App\Component\UI\UI;

return static function ($ctx, $di) {
    $content = [];
    /** @var UI $spectator */
    $spectator = $di->get('ui');

    $content[] = $spectator->render('bootstrap/alert', 'Тут еще нет работ');

    return <<<HTML
<div class="mt-4 d-none">
    {$spectator->render('bootstrap/infobox', $content, ['Работы', 'javascript:void(0);'])}
</div>
<div class="container p-0">
    <!-- HEADER -->
    <div class="row">
        <div class="col">
            <a class="square" href="javascript:void(0);">Работы</a>
        </div>
        <div class="col-3 text-right">
            <a href="javascript:void(0);">Добавить</a>
        </div>
    </div>
    <!-- HEADER -->
</div>
HTML;
};
