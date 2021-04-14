<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

return static function ($context) {
    $profile   = $context['profile'];
    $firstName = ' ' !== profile_peer::get_name($profile, '&fn ')
        ? profile_peer::get_name($profile, '&fn ')
        : profile_peer::get_name($profile, '&fn ', 'ru');
    $lastName  = ' ' !== profile_peer::get_name($profile, '&ln ')
        ? profile_peer::get_name($profile, '&ln ')
        : profile_peer::get_name($profile, '&ln ', 'ru');
    $link      = static function ($profile) {
        if (
            !empty($profile['last_name_en'])
            || !empty($profile['first_name_en'])
            || !$profile['active']
            || 'en' !== session::get('language', 'ru')
        ) {
            return null;
        }

        return <<<HTML
<a href="/profile/edit?id={$profile['user_id']}"
   class="fs12 cgray underline"
   onmouseover="$(this).removeClass('underline')"
   onmouseout="$(this).addClass('underline')"
>Заполните свои данные на английском языке</a>
HTML;
    };
    $reserve   = static function ($profile) {
        if ($profile['reserv'] <= 0 || !session::has_credential('admin')) {
            return null;
        }
        $buildStyle = static function ($data) {
            return implode(
                '; ',
                array_map(
                    static function ($key, $value) {
                        return sprintf('%s: %s', $key, $value);
                    },
                    array_keys($data),
                    array_values($data)
                )
            );
        };

        $uid      = $profile['user_id'];
        $cssStyle = [
            'color'         => '#999',
            'background'    => '#eee',
            'border-top'    => '1px solid #ccc',
            'border-bottom' => '1px solid #ccc',
        ];

        return <<<HTML
<div class="p5 mb10 fs12" style="{$buildStyle($cssStyle)}">
    В резерве :: <a id="profile-from_reserv" href="javascript:void(0);">Восстановить</a>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#profile-from_reserv').click(function () {
            if (confirm('Вы действительно хотите восстановить этот профиль?')) {
                $.post('/profile', {
                    'act': 'from_reserv',
                    'id': '{$uid}'
                }, function (response) {
                    if (response.success) {
                        window.location = '/profile?id={$uid}'
                    }
                }, 'json');
            }
        });
    });
</script>
HTML;
    };

    $followersCount = static function () use ($profile) {
        $count = profile_peer::instance()
            ->getInstagramFollowersCount($profile['user_id']);

        if (null === $count) {
            return null;
        }

        return <<<HTML
<div class="right">
    <div class="badge badge-dark">{$count}</div>
</div>
HTML;
    };

    return <<<HTML
<!-- START OF FULL NAME -->
<div class="fs30" style="color: #000000">
    <div class="left font-weight-bold">
        <span>{$firstName}</span>
        <span class="text-uppercase">{$lastName}</span><br/>
        {$link($profile)}
    </div>
    {$followersCount()}
    <div class="clear"></div>
</div>
{$reserve($profile)}
<!-- END OF FULL NAME -->
HTML;
};