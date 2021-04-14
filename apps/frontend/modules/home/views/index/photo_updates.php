<?php

return static function ($boxes) {
    $images = implode(
        PHP_EOL,
        array_map(
            static function ($box) {
                rsort($box['images']);

                return <<< HTML
<div style="position: relative">
    <img alt="" src="/imgserve?pid={$box['images'][0]}&h=320"
         class="img-fluid"
         style="object-fit: cover; width: 100%; height: 320px"/>
</div>
HTML;
            },
            $boxes
        )
    );

    return <<< HTML
<div class="px-3">
    <div class="row">
        <div class="col small-title square_p pl10">
            <a href="/updates">Новые фотографии</a>
        </div>
    </div>
    <div class="row">
        <div class="grid auto-flow-column justify-content-between" style="grid-template-columns: repeat(4, 240px)">{$images}</div>
    </div>
</div>
HTML;
};

