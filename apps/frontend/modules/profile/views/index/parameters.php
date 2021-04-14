<?php

$badge = static function ($label, $value, $units = null) {
    return <<<HTML
<div class="pr-2">{$label} <span class="badge badge-dark fs12">{$value} {$units}</span></div>
HTML;
};

return static function ($context) use ($badge) {
    $profile = $context['profile'];
    $params  = profile_peer::instance()->get_params($profile['user_id']);
    $badges  = [];

    if ((int)$params['growth'] > 0) {
        $badges[] = $badge('', $params['growth'], 'см');
    }

    if ((int)$params['weigth'] > 0) {
        $badges[] = $badge('', $params['weigth'], 'кг');
    }

    if (
        (int)$params['breast'] > 0 &&
        (int)$params['waist'] > 0 &&
        (int)$params['hip'] > 0
    ) {
        $badges[] = $badge('', sprintf('%s / %s / %s', $params['breast'], $params['waist'], $params['hip']));
    }

    if (empty($badges)) {
        return null;
    }

    return sprintf('<div class="d-flex flex-row mt-2 fs12">%s</div>', implode(PHP_EOL, $badges));
};