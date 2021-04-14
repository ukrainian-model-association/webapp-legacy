<?php

$registerLink = static function ($link) {
    $checkup = isset($link['checkup']) ? $link['checkup'] : null;

    if (is_callable($checkup) && !$checkup()) {
        return null;
    }

    return <<<HTML
<div class="register-link right">
    <a href="{$link['href']}" class="cpurple">{$link['text']}</a>
</div>
HTML;
};

$includeGirls = static function ($most) {
    ob_start();
    include __DIR__.'/girls.php';

    return ob_get_clean();
};

class Collage {

}

return static function ($context) use ($registerLink, $includeGirls) {
    $links = [];
    if (isset($context['register_links']) && is_array($context['register_links'])) {
        foreach ($context['register_links'] as $link) {
            $links[] = $registerLink($link);
        }
    }
    $links = implode(PHP_EOL, $links);

    return <<<HTML
<div>
    <div class="small-title square_p">
        <a href="{$context['href']}">{$context['title']}</a>
    </div>
    {$links}
</div>
{$includeGirls($context['collection'])}
HTML;
};