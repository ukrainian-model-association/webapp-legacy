<?php

/**
 * @param array            $ctx
 * @param ServiceContainer $di
 *
 * @return string
 */

use App\Component\ServiceContainer;
use App\Component\UI\UI;

return static function ($ctx, $di) {
    /** @var UI $ui */
    $ui     = $di->get('ui');
    $images = $ctx['images'];

    if (empty($images)) {
        return null;
    }

    $images  = array_slice($ctx['images'], 0, 6);
    $content = [
        '<div class="d-flex flex-row justify-content-between py-2" id="portfolio">',
        implode(
            PHP_EOL,
            array_map(
                static function ($photoId) {
                    $imgSrc = sprintf('/imgserve?pid=%s&h=100', $photoId);

                    return sprintf(
                        '<img data-photo-id="%s" src="%s" class="img-fluid img-thumbnail rounded" style="width: 75px; object-fit: cover" alt="..."s>',
                        $photoId,
                        $imgSrc
                    );
                },
                $images
            )
        ),
        '</div>',
    ];

    return $ui->render(
        'layout/panel',
        [
            'title'   => 'Портфолио',
            'content' => implode(PHP_EOL, $content),
        ],
        [
            'class' => 'mt-4',
        ]
    );
};
