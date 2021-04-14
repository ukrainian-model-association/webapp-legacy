<?php

/**
 * @param array $context
 *
 * @return null|string
 */
return static function ($context) {
    $profile = $context['profile'];

    if (!$profile['del'] || !session::has_credential('admin')) {
        return null;
    }

    $del_hist    = profile_peer::instance()->get_last_del_hist($profile['user_id']);
    $date        = date('Y-m-d', $del_hist['time']);
    $remover     = profile_peer::instance()->get_item($del_hist['operator']);
    $removerName = profile_peer::get_name($remover);

    return <<<HTML
<div class="mb10 bold">
    <div class="p10 cwhite" style="background: #c00;">
        <span>Удалена {$date}</span><br/>
        <span class="fs10">Удалил:</span> <a class="fs10 cgray" href="/profile/?id={$remover['user_id']}">
        {$removerName}
    </a><br/>
    </div>
</div>
HTML;
};
