<?php

return static function ($message) {
    $classList = implode(
        ' ',
        ['alert alert-dark m-0 border-0 rounded-0 fs12 text-center text-muted']
    );

    return <<<HTML
<div class="{$classList}" role="alert">{$message}</div>
HTML;
};
