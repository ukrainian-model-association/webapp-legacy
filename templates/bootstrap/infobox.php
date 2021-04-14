<?php

/**
 * @param string|array      $content
 * @param null|string|array $title
 * @param array             $state
 *
 * @return string
 */
return static function ($content, $title = null, $state = []) {
    $fn      = [
        'header' => static function ($title, $titleStyles) {
            list($text, $href) = !is_array($title) ? [$title] : $title;

            if (!is_string($text) || empty($text)) {
                return null;
            }

            $titleStyles = sprintf('style="%s"', implode('; ', $titleStyles));

            return null !== $href
                ? sprintf('<a class="square" %s data-toggle="button" href="%s">%s</a>', $titleStyles, $href, $text)
                : $text;
        },
    ];
    $content = is_array($content)
        ? implode(PHP_EOL, $content)
        : $content;

    $titleStyles   = [];
    $bodyClassList = ['infobox-body'];
    if (array_key_exists('hidden', $state) && true === $state['hidden']) {
        $titleStyles[]   = 'opacity: .5';
        $bodyClassList[] = 'd-none';
    }
    $bodyClassList = implode(' ', $bodyClassList);

    return <<<HTML
<div class="container mt-4 px-0">
    <div class="row">
        <div class="col py-1">{$fn['header']($title, $titleStyles)}</div>
    </div>
    <hr/>
    <div class="{$bodyClassList}">{$content}</div>
</div>
HTML;
};