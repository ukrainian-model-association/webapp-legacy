<?php

/**
 * This file is part of the @modelsua package.
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
    if (!session::has_credential('admin')) {
        return null;
    }

    /** @var UI $ui */
    $ui      = $di->get('ui');
    $content = [];
    $profile = $ctx['profile'];
    $uid     = $profile['user_id'];

    // ob_start();
    // include __DIR__.'/admin_block/generic.php';
    // $generic = ob_get_clean();

    $profileTypes = profile_peer::get_types_list();
    $profileTypes = implode(
        PHP_EOL,
        array_map(
            static function ($value, $key) use ($profile) {
                $options = implode(
                    PHP_EOL,
                    array_map(
                        static function ($text, $value) use ($profile) {
                            return sprintf(
                                '<option value="%s"%s>%s</option>',
                                $value,
                                $value === (int) $profile['status'] ? ' selected="selected"' : null,
                                $text
                            );
                        },
                        array_values($value['status']),
                        array_keys($value['status'])
                    )
                );

                return <<<HTML
<optgroup label="{$value['type']}">{$options}</optgroup>
HTML;
            },
            array_values($profileTypes),
            array_keys($profileTypes)
        )
    );

    $catalogTypes = [
        profile_peer::SUCCESSFUL  => 'Успешные',
        profile_peer::NEW_FACES   => 'Новые лица',
        profile_peer::PERSPECTIVE => 'Перспективные',
        profile_peer::LEGENDARY   => 'Самые успешные',
    ];
    $statusType   = profile_peer::instance()
        ->useContext($profile)
        ->getStatusType();

    $catalog = implode(
        PHP_EOL,
        array_map(
            static function ($text, $value) use ($statusType) {
                $selected = null;
                if ($value === $statusType) {
                    $selected = ' selected="selected"';
                }

                return sprintf('<option value="%s"%s>%s</option>', $value, $selected, $text);
            },
            array_values($catalogTypes),
            array_keys($catalogTypes)
        )
    );

    /**
     * @param bool $state
     *
     * @return string
     */
    $checked = static function ($state) {
        if (true !== $state) {
            return null;
        }

        return 'checked="checked"';
    };

    $milestone = implode(
        PHP_EOL,
        array_map(
            static function ($value, $text) {
                return sprintf(
                    '<button class="btn btn-sm btn-outline-dark" type="button" value="%s">%s</button>',
                    $value,
                    null !== $text ? $text : $value
                );
            },
            range(0, 5),
            ['-']
        )
    );


    $isActiveWidget = static  function ($profile) {
        $output = [];

        if ($profile['active']) {
            $output[] = '<b>Активная</b>';
        }

        if ($profile['activated_ts'] > 0) {
            $output[]= date('d.m.Y', $profile['activated_ts']);
        }

        return implode(PHP_EOL, $output);
    };

    $content[] = <<<HTML
<div class="card text-dark bg-light rounded-0 border-0 fs14">
    <div class="card-body">
        <div class="input-group input-group-sm mb-3 d-none">
            <div class="input-group-prepend" style="width: 15%">
                <label class="input-group-text w-100" for="statusType">Списки</label>
            </div>
            <select data-uid="{$uid}"
                    class="custom-select custom-select-sm"
                    name="additional-list-change[]"
                    id="statusType">
                <option value="-1">&mdash;</option>
                {$catalog}
            </select>
        </div>

        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend" style="width: 15%">
                <label class="input-group-text w-100" for="personType">Тип</label>
            </div>
            <select class="custom-select custom-select-sm" id="personType">{$profileTypes}</select>
        </div>

        <div class="row">
            <div class="col">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="successfulModel" {$checked((bool) $profile['successful_model'])}>
                    <label class="custom-control-label" for="successfulModel">Самая успешная</label>
                </div>
                <div class="custom-control custom-switch">
                    <input class="custom-control-input" id="memberOfAssociation" type="checkbox"  {$checked((bool) $profile['member_of_association'])}>
                    <label class="custom-control-label" for="memberOfAssociation">Член ассоциации</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="custom-control custom-switch">
                    <input class="custom-control-input" id="isHidden" type="checkbox" {$checked((bool) $profile['hidden'])}>
                    <label class="custom-control-label" for="isHidden">Скрытый</label>
                </div>
                <div class="custom-control custom-switch">
                    <input class="custom-control-input" id="hasConversationAccess" type="checkbox" {$checked((bool) $profile['can_write'])}>
                    <label class="custom-control-label" for="hasConversationAccess">Может переписываться</label>
                </div>
            </div>
            <div class="col-5 text-right">
                <div aria-label="" data-uid="{$uid}"
                     class="btn-group"
                     id="milestone"
                     data-value="{$profile['milestone']}}"
                     role="group">
                    {$milestone}
                </div>
            </div>
        </div>
        
        <div class="mt-3 btn-group">
            <a class="btn btn-primary" id="adminka-remove-archive-item-" href="javascript:void(0);">* В архив</a>
            <a class="btn btn-primary" id="adminka-reserv" href="javascript:void(0);">* В резерв</a>
        </div>
        
        <div class="mt-3">
            {$isActiveWidget($profile)}            
        </div>

    </div>
</div>
HTML;

    return <<<TAG
<div data-uid="{$uid}" id="admin">
{$ui->render(
        'layout/panel',
        [
            'title'   => 'Aдмин',
            'content' => implode(PHP_EOL, $content),
        ],
        [
            'collapsed' => true,
        ]
    )}
</div>
TAG;
};
