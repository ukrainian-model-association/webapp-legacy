<?php

/**
 * @param array            $ctx
 * @param ServiceContainer $di
 *
 * @return string
 */

use App\Component\ServiceContainer;
use App\Component\UI\UI;

/**
 * @param                  $ctx
 * @param ServiceContainer $di
 *
 * @return null|string
 */
return static function ($ctx, $di) {
    /** @var UI $ui */
    $ui         = $di->get('ui');
    $profile    = $ctx['profile'];
    $collection = $ctx['collection'];

    if (2 !== (int) profile_peer::get_type_by_user($profile['user_id'])) {
        return null;
    }

    $addButton    = static function ($userId) {
        if (
            session::get_user_id() !== $userId
            && !session::has_credential('admin')
        ) {
            return null;
        }

        return <<<HTML
<a class="cgray" href="javascript:void(0);" onclick="$('#window-smi').show();">Добавить</a>
HTML;
    };
    $removeButton = static function ($userId) {
        if (
            session::get_user_id() !== $userId
            && !session::has_credential('admin')
        ) {
            return null;
        }

        return <<<TAG
<button type="button" class="close" id="remove-smi-{$userId}" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
TAG;
    };
    $listItem     = static function ($item, $seqNum) use ($removeButton, $profile) {
        $x = null;

        if (true !== $item['protected']) {
            $x = $removeButton($profile['user_id']);
        }

        return <<<HTML
<li class="list-group-item d-flex flex-row px-0 py-1">
    <span class="pr-2">–</span> 
    <a href="{$item['link']}" style="flex-grow: 1; color: black" class="btn-link">{$item['name']}</a>
    <div style="width: 16px">{$x}</div>
</li>
HTML;
    };
    $content      = static function ($collection) use ($ui, $listItem) {
        if (empty($collection)) {
            return $ui->render('bootstrap/alert', 'Тут еще нет работ');
        }

        return <<<TAG
<ul class="list-group list-group-flush">
    {$ui->map($listItem, $collection, range(1, count($collection)))}
</ul>
TAG;
    };

    return <<<HTML
<div class="position-relative">
    <div id="window-smi" class="hide" style="box-sizing: border-box; position: absolute; z-index: 1; width: 60%; left: 20%">
        <div class="card shadow-lg bg-white border-secondary rounded">
            <form id="form-smi" action="/profile?id={$profile['user_id']}" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm w-100" id="name" placeholder="Название"/>
                    </div>

                    <div class="form-group mb-0">
                        <input type="text" class="form-control form-control-sm w-100" id="link" placeholder="Ссылка"/>
                    </div>

                    <div id="msg-success-smi" class="mt10 acenter d-none" style="color: #090;">Данные сохранены успешно</div>
                    <div id="msg-error-smi" class="mt10 acenter d-none" style="color: #900;">Ошибка: проверьте, все ли данные введены правильно</div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col text-right">
                            <button class="btn btn-sm btn-secondary text-white mr-1" id="submit">Сохранить</button>
                            <button class="btn btn-sm btn-secondary text-white" onclick="$('#window-smi').hide();">Отмена</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
{$ui->render(
        'layout/panel',
        [
            'title'   => 'СМИ',
            'content' => $content($collection),
        ],
        [
            'class'          => 'mt-4',
            'header_buttons' => [
                $addButton($profile['user_id']),
            ],
        ]
    )}
HTML;
};
