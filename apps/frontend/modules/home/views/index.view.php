<?php

/**
 * @var html_render $this
 * @var array $successfulModels
 * @var array $legendary
 * @var array $perspective
 * @var array $new_faces
 * @var array $boxes
 * @var callable $photosRow
 * @var array $associationMembers
 */

/** @var home_index_action $controller */
$controller = $this->controller;

$photosRow = require __DIR__.'/index/photos_row.php';

$makeImageUrl = static function ($urlPath) {
    return sprintf('https://img.%s/%s', conf::get('server'), ltrim($urlPath, '/'));
}

?>
<div>
    <div class="font-weight-bold" style="position: absolute; left: 220px">
        <?php
        $filters     = array_map(
                static function ($filter, $value) {
                    $href       = '/people';
                    $extraStyle = null;

                    if (null !== $filter) {
                        $href = sprintf('%s?filter=%s', $href, $filter);
                    }

                    return sprintf(
                            '<a href="%s" class="font-weight-bold text-uppercase" style="font-size: 12px; %3$s">%2$s</a>',
                            $href,
                            $value,
                            $extraStyle
                    );
                },
                [
                        people_index_action::FILTER_MODELSCOM_MODELS,
                        people_index_action::FILTER_INSTAGRAM_MODELS,
                ],
                [
                        'Models.com',
                        'instagram',
                ]
        );
        $filters[]   = sprintf(
                '<a href="%s" class="font-weight-bold text-uppercase" style="font-size: 12px">
            <i class="material-icons" style="font-size: 16px; vertical-align: middle">search</i>%s</a>',
                '/search',
                'Поиск'
        );
        ?>
    </div>

    <?= $photosRow(
            [
                    'title'          => sprintf('%s</a> | %s<a>', t('Самые успешные модели'), implode(' | ', $filters)),
                    'href'           => sprintf('/people?filter=%s', people_index_action::FILTER_SUCCESSFUL_MODELS),
                    'css'            => 'mt5',
                    'collection'     => $successfulModels,
                    'register_links' => array_map(
                            static function ($filter, $value) {
                                $href       = '/people';
                                $extraStyle = null;

                                if (null !== $filter) {
                                    $href = sprintf('%s?filter=%s', $href, $filter);
                                }

                                // return sprintf(
                                //         '<a href="%s" class="font-weight-bold text-uppercase" style="font-size: 12px; %3$s">%2$s</a>',
                                //         $href,
                                //         $value,
                                //         $extraStyle
                                // );

                                return [
                                        'text'   => '',
                                        'href'   => $href,
                                        'enable' => function () {
                                            return true;
                                        },
                                ];
                            },
                            [
                                    people_index_action::FILTER_MODELSCOM_MODELS,
                                    people_index_action::FILTER_INSTAGRAM_MODELS,
                            ],
                            [
                                    'Models.com',
                                    'instagram',
                            ]
                    ),

                    // 'register_links' => [
                    //
                    //
                    //         [
                    //                 'text'   => t('Хочу стать моделью'),
                    //                 'href'   => '/sign/registration',
                    //                 'enable' => static function () {
                    //                     return !session::is_authenticated();
                    //                 },
                    //         ],
                    //         [
                    //                 'text'   => t('Пригласи подругу'),
                    //                 'href'   => '/invite',
                    //                 'enable' => static function () {
                    //                     return session::is_authenticated();
                    //                 },
                    //         ],
                    // ],
            ]
    ) ?>
</div>

<?php if (count($associationMembers) > 0) { ?>
    <?= $photosRow(
            [
                    'title'      => t('Члены ассоциации'),
                    'href'       => sprintf('/people?filter=%s', people_index_action::FILTER_ASSOCIATION_MEMBERS),
                    'collection' => $associationMembers,
            ]
    ) ?><?php } ?>

<?php //= $photosRow(
// [
//     'title'      => t('Перспективные'),
//     'href'       => '/people?status=perspective',
//     'collection' => $perspective,
// ]
// )?>

<?php //= $photosRow(
// [
//     'title'      => t('Новые лица'),
//     'href'       => '/people?status=new-face',
//     'collection' => $new_faces,
// ]
// )?>

<script type="text/javascript">
    $(document).ready(function () {
        $('div.main-page-gallery > div.image-box > a[data-user-id] > img')
                .mouseout(function (e) {
                    $(e.target.parentNode.querySelector('div[data-tooltip]')).hide();
                })
                .mousemove(function (e) {
                    $(e.target.parentNode.querySelector('div[data-tooltip]'))
                            .show()
                            .css({
                                'top': e.pageY + 16,
                                'left': e.pageX + 16,
                                'zIndex': '999',
                            });
                });

    });
</script>

<?= call_user_func(require __DIR__.'/index/LastPhotoUpdatesView.php') ?>
<?php //= call_user_func(require __DIR__.'/index/photo_updates.php', $boxes)?>

<div class="grid auto-flow-column auto-fit cg-3 mt-2">
    <div class="brief">
        <a href="/people" class="brief-title first-letter squared">Каталог моделей</a> <a href="/people">
            <img alt="Каталог моделей" src="/home/model-catalog.jpg" class="brief-img w-100" style="height: 400px"/>
        </a>
    </div>

    <div class="brief">
        <a href="/polls" class="brief-title first-letter squared">Рейтинг популярности</a>
        <?= call_user_func(require __DIR__.'/index/PopularityRatingView.php', [$model1, $model2], $check_vote, $di) ?>
    </div>


    <div class="brief">
        <a href="/agency/list" class="brief-title first-letter squared">Каталог агенств</a> <a href="/agency/list">
            <img alt="Рейтинг журналов" class="brief-img w-100" src="/home/agency-catalog.jpg" style="height: 400px">
        </a>
    </div>

</div>

<?= call_user_func(require __DIR__.'/index/PostsIndexHomeView.php', []) ?>

<div class="grid auto-flow-column auto-fit cg-3 mt-3 d-none">
    <div class="brief">
        <div class="small-title square_p pl10 mb5">
            <a href="/news?type=1"><?= t('Новости') ?></a>
        </div>
        <div class="brief-header">
            <a href="/news/view?id=<?= $news['id'] ?>" class="brief-title first-letter detached"><?= $news['title'] ?></a>
        </div>
        <div class="mt-1">
            <div class="text-muted italic mb-1"><?= date('d.m.Y', $news['created_ts']); ?></div>
            <div>
                <div>
                    <a href="/news/view?id=<?= $news['id'] ?>"> <img alt="<?= $news['title'] ?>" src="<?= $makeImageUrl(
                                sprintf('/m/%s.jpg', $news['salt'])
                        ) ?>" class="brief-img"/> </a>
                </div>
                <div class="fs14 mt10 mb10 bold ucase acenter">
                    <a href='/news?type=1' class="cpurple underline"><?= t('Все новости') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="brief">
        <div class="small-title square_p pl10 mb5">
            <a href="/news?type=2"><?= t('Публикации') ?></a>
        </div>
        <div class="brief-header">
            <a href="/news/view?id=<?= $publication['id'] ?>" class="brief-title first-letter detached"><?= $publication['title'] ?></a>
        </div>
        <div class="mt-1">
            <div class="text-muted italic mb-1"><?= date('d.m.Y', $publication['created_ts']) ?></div>
            <div>
                <div>
                    <a href="/news/view?id=<?= $publication['id'] ?>">
                        <img alt="<?= $publication['title'] ?>" src="" class="brief-img"/> </a>
                </div>
                <div class="fs14 mt10 mb10 bold ucase acenter">
                    <a href='/news?type=2' class="cpurple underline"><?= t('Все публикации') ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="brief">
        <div class="small-title square_p pl10 mb5">
            <a href="/news?type=3"><?= t('Анонсы') ?></a>
        </div>
        <div class="brief-header">
            <a href="/news/view?id=<?= $anons['id'] ?>" class="brief-title first-letter detached"><?= $anons['title'] ?></a>
        </div>
        <div class="mt-1">
            <div class="text-muted italic mb-1"><?= date('d.m.Y', $anons['created_ts']) ?></div>
            <div>
                <div>
                    <a href="/news/view?id=<?= $anons['id'] ?>">
                        <img alt="<?= $anons['title'] ?>" src="https://img.<?= conf::get(
                                'server'
                        ) ?>/m/<?= $anons['salt'].'.jpg' ?>" class="brief-img"/> </a>
                </div>
                <div class="fs14 mt10 mb10 bold ucase acenter">
                    <a href='/news?type=3' class="cpurple underline"><?= t('Все анонсы') ?></a>
                </div>
            </div>
        </div>
    </div>

</div>

<style type="text/css">
    div.updates div.update {
        float: left;
        margin-right: 35px;
    }

    div.updates div.update:last-child {
        margin-right: 0px;
    }

    div.updates div.update div.photo {
        width: 220px;
        height: 295px;
    }

    div.updates div.update div.desc {
        margin-top: 0px;
        padding: 10px;
        background: rgba(0, 0, 0, 0.75);
        font-size: 12px;
        font-weight: bold;
    }
</style>

<script type="text/javascript">
    $(document).ready(function () {
        $('div.update').mouseenter(function (e) {
            var desc = $('div.desc', this);

            if (typeof $(desc).attr('h') == 'undefined')
                $(desc).attr('h', $(desc).height());

            var height = $(desc).attr('h');
            var margin = parseInt(height) + parseInt($(desc).css('padding-top')) * 2;

            $(desc)
                    .animate({
                        'margin-top': '-' + margin + 'px',
                    }, 256);
        })
                .mouseleave(function (e) {
                    var desc = $('div.desc', this);

                    $(desc)
                            .animate({
                                'margin-top': '0px',
                            }, 256);
                });

        $('div.update div.photo').click(function () {
            var photo = $(this);
            var category = $(this).attr('category');
            var step = parseInt($(this).attr('step')) + 1;
            $(this).attr('step', step);

            $.post('/home', {
                'act': 'get_next_update',
                'category': category,
                'step': step,
            }, function (response) {
                if (response.success) {
                    $(photo).css('background', 'url(\'/imgserve?pid=' + response.image + '&h=295\') center');
                    $(photo).next().html(response.user_name);
                }
            }, 'json');
        });
    });
</script>

<div id="popup_image_box" class="hide" style="position:absolute; background: #fff; padding: 5px; -moz-box-shadow: 0 0 5px 1px #9CA1AE;">
    <a href="/"><img src="" style="width: 90px;"></a>
</div>
<script>
    jQuery(document).ready(function ($) {
        // $('.image-box').find('img').hover(
        //     function () {
        //         $('#popup_image_box img').attr('src', $(this).attr('src'));
        //         $('#popup_image_box a').attr('href', $(this).parent().attr('href'));
        //
        //         $('#popup_image_box').css('left', ($(this).position().left - 10)).css('top', ($(this).position().top - 7));
        //         $('#popup_image_box').removeClass('hide');
        //     },
        //     function () {}
        // );
        // $('#popup_image_box').hover(function () {}, function () {
        //     $(this).addClass('hide');
        //     $('#popup_image_box img').attr('src', '');
        // });
    });

    function show_info() {
        Popup.show();
        Popup.setHtml('Вы уже за всех проголосовали<br/><div class="mt5 acenter"><a href="/polls/rating?type=1" class="mt5 fs12"><i>Смотреть рейтинг</i></a></div><input value="Закрыть" type="button" class="mt10" onClick="Popup.close(300)"/>');
        Popup.position();
    }
</script>
