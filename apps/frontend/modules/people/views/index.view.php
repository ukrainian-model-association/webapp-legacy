<?php
/**
 * @var html_render $this
 * @var Paginator $paginator
 * @var pager $pager
 * @var array $collection
 */
/** @var people_index_action $ctrl */
$ctrl = $this->controller;
?>

<?php if (session::get_user_id() === 2380) { ?>
    <div id="firstModelsList" data-group-id="" class="connectedSortable position-absolute bg-primary text-white p-3" style="top: 0; right: 0; width: 300px; min-height: 100px">

    </div>
    <div id="secondModelsList" class="connectedSortable position-absolute bg-dark text-white p-3" style="bottom: 0; right: 0; width: 300px; min-height: 100px">

    </div>
<?php } ?>

<div class="mb10 fs12">

    <div class="square_p pl15 mt20 mb20 ucase bold left">
        <?= t('Каталог моделей Украины') ?>
    </div>
    <div class="register-link right mt20 mb20 mr25 <?= ('en' === session::get('language')) ? ' hide' : '' ?>">
        <a href="/sign/registration" class="cpurple"><?= t('Зарегистрироваться в каталоге') ?></a>
    </div>
    <div class="clear"></div>

    <?php if (session::has_credential('admin')) { ?>
        <div class="mb-3 container p-0">
            <div class="row align-content-between align-items-center">
                <div class="col">
                    <?php
                    $filters     = array_map(
                            function ($filter, $value) use ($ctrl) {
                                $href       = '/people';
                                $extraStyle = null;

                                if (null !== $filter) {
                                    $href = sprintf('%s?filter=%s', $href, $filter);
                                }

                                if ($filter === $ctrl->getFilter() || ('' === $filter && null === $ctrl->getFilter())) {
                                    $extraStyle = implode(
                                            ';',
                                            [
                                                    'background-color: #000000',
                                                    'border-radius: 5px',
                                                    'padding: 5px 10px',
                                                    'color: white',
                                            ]
                                    );
                                }

                                return sprintf(
                                        '<a href="%s" style="font-size: 12px; font-weight: normal; text-transform: uppercase; %3$s">%2$s</a>',
                                        $href,
                                        $value,
                                        $extraStyle
                                );
                            },
                            array_keys(people_index_action::FILTERS),
                            array_values(people_index_action::FILTERS)
                    );
                    $filters[]   = sprintf(
                            '<a href="%s" class="text-uppercase" style="font-size: 12px">
            <i class="material-icons" style="font-size: 16px; vertical-align: middle">search</i>%s</a>',
                            '/search',
                            'Поиск'
                    );
                    $filtersView = implode(' | ', $filters);
                    ?>
                    <?= $filtersView ?>
                </div>
                <div class="col-3 text-right">
                    <div id="milestones" class="btn-group" role="group" aria-label="...">
                        <?= implode(
                                PHP_EOL,
                                array_map(
                                        static function ($i) {
                                            return sprintf(
                                                    '<button type="button" class="btn btn-outline-secondary" value="%s">%1$s</button>',
                                                    $i
                                            );
                                        },
                                        range(1, 5)
                                )
                        ) ?>
                    </div>
                    <script type="application/javascript">
                        (() => {
                            const btnGroup = document.querySelector('div[role="group"]#milestones'),
                                    buttonList = btnGroup.querySelectorAll(':scope > button.btn'),
                                    url = new URL(window.location.href),
                                    milestone = parseInt(url.searchParams.get('milestone')),
                                    handleBtnClick = ({target: {value}}) => {
                                        const searchParams = new URLSearchParams();
                                        searchParams.set('milestone', value);
                                        url.search = '?' + searchParams.toString();
                                        window.location.assign(url.toString());
                                    };

                            if (milestone > 0) {
                                buttonList[milestone - 1].classList.replace('btn-outline-secondary', 'btn-secondary');
                            }

                            buttonList.forEach(b => {
                                b.addEventListener('click', handleBtnClick);
                            });
                        })();
                    </script>
                </div>
            </div>
        </div>
    <?php } ?>
    <div>
        <style type="text/css">
            #sortable, sortable2 {
                list-style-type: none;
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .ui-state-highlight {
                background: #fff;
                border: none;
                padding: 1px;
                float: left;
                width: 165px;
                height: 165px;
            }
        </style>

        <div class="mb10" style="width: 1024px; height: 668px; overflow: hidden;">
            <ul id="sortable" class="connectedSortable" style="height: 675px">
                <?php foreach ($collection as $user_id) { ?>
                    <?php $profile = profile_peer::instance()->get_item($user_id) ?>
                    <?php $crop = unserialize($profile['ph_crop']) ?>
                    <?php $avatar = profile_peer::instance()->getAvatar($profile) ?>

                    <li class="ui-state-highlight" id="member-blind-<?= $profile['user_id'] ?>" rel="<?= $profile['rank'] ?>">
                        <div class="position-relative">
                            <?php if (null !== ($followersCount = profile_peer::instance()->getInstagramFollowersCount(
                                            $user_id
                                    ))) { ?>
                                <span class="badge badge-light fs10" style="position: absolute; right: .25rem; bottom: .25rem"><?= $followersCount ?></span>
                            <?php } ?>
                            <?= $avatar->setStyle(['width' => '165px', 'height' => '165px']) ?>
                        </div>
                        <div id="member-tooltip-<?= $user_id ?>" class="hide p10 bold" style="position: absolute; background: black; color: white; border-radius: 5px;">
                            <?= profile_peer::get_name($profile) ?><br/>
                            <?php if (null !== ($age = profile_peer::getAge($profile))) { ?>
                                <span class="fs10"><?= $age ?></span>
                            <?php } ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
            <div class="clear"></div>
        </div>

        <script type="text/javascript">
            (($) => {
                $(document).ready(function () {
                    const container = document.querySelector('ul[id="sortable"].connectedSortable');
                    let mouseDown = null;

                    $('li[id^=\'member-blind\']')
                            .mouseout(function () {
                                $(`#member-tooltip-${$(this).attr('id').split('-')[2]}`).hide();
                            })
                            .mousedown(function (e) {
                                mouseDown = new Date();
                            })
                            .mousemove(function (e) {
                                const element = $(`#member-tooltip-${$(this).attr('id').split('-')[2]}`);

                                if (mouseDown !== null) {
                                    return element.hide();
                                }

                                element.show()
                                        .css({
                                            'top': e.pageY + 16,
                                            'left': e.pageX + 16,
                                            'zIndex': '999',
                                        });
                            })
                            .click(function (e) {
                                if (new Date() - mouseDown < 150) {
                                    window.location = `/profile?id=${$(this).attr('id').split('-')[2]}`;
                                }
                            });

                    <?php if (session::has_credential('admin')) { ?>
                    $('#sortable, #sortable2, #firstModelsList, #secondModelsList')
                            .sortable({
                                connectWith: '.connectedSortable',
                                placeholder: 'ui-state-highlight',
                                start: (event, ui) => {
                                    const node = ui.item[0];
                                    const nodeList = container.querySelectorAll(':scope > li');
                                    const nodeIndex = Array.prototype.indexOf.call(nodeList, node);

                                    console.log(nodeIndex);
                                },
                                stop: function (event, ui) {

                                    if ($(ui.item).next().length > 0) {
                                        $(ui.item).attr('rel', $(ui.item).next().attr('rel'));
                                    } else if ($(ui.item).prev().length > 0) {
                                        $(ui.item).attr('rel', parseInt($(ui.item).prev().attr('rel') + 1));
                                    }

                                    const data = [];

                                    $.each($('#sortable > li'), function () {
                                        var rel = parseInt($(this).attr('rel'));

                                        data.push({
                                            'user_id': $(this).attr('id').split('-')[2],
                                            'rank': rel,
                                        });

                                        if ($(this).next().length < 1)
                                            return;

                                        var xrel = $(this).next().attr('rel');
                                        if (rel !== xrel - 1) {
                                            $(this).next().attr('rel', rel + 1);
                                        }
                                    });

                                    const hold = [];

                                    $.each($('#sortable2 > li'), function () {
                                        hold.push($(this).attr('id').split('-')[2]);
                                    });

                                    $.post('/people/set-partial-ordering', {
                                        'data': data,
                                        'hold': hold,
                                    }, function (resp) {
                                        console.log(resp);
                                    }, 'json');
                                },
                            })
                            .disableSelection();
                    <?php } ?>
                });
            })(jQuery);
        </script>

        <?php if (session::has_credential('admin')) { ?>
            <div style="width: 1000px; height: 197px; border: 1px solid #ccc; overflow: auto">
                <div class="pt5 pl5" style="width: 10000px;">
                    <ul id="sortable2" class="connectedSortable" style="height: 177px;">
                        <?php foreach ($holdPeople as $user_id) { ?>
                            <?php $profile = profile_peer::instance()->get_item($user_id); ?>
                            <?php $crop = unserialize($profile['ph_crop']) ?>
                            <li class="ui-state-highlight" id="member-blind-<?= $profile['user_id'] ?>" rel="<?= $profile['rank'] ?>">
                                <img src="<?php if ($profile['pid']) { ?>/imgserve?pid=<?= $profile['pid'] ?>&x=<?= $crop['x'] ?>&y=<?= $crop['y'] ?>&w=<?= !$crop['w']
                                        ? '165' : $crop['w'] ?>&h=<?= !$crop['h'] ? '165'
                                        : $crop['h'] ?>&z=crop<?php } else { ?>/no_image.png<?php } ?>" style="width: 165px; height: 165px;"/>
                                <div id="member-tooltip-<?= $user_id ?>" class="hide p10 bold" style="position: absolute; background: black; color: white; border-radius: 5px;"><?= profile_peer::get_name(
                                            $profile
                                    ) ?></div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        <?php } ?>

        <table width="100%">
            <tr>
                <td align="center">
                    <div class="paginator">
                        <?= $paginator ?>
                        <span class="text-muted float-right"><?= $countOfMembers ?></span>
                    </div>
                </td>
            </tr>
        </table>

    </div>

    <!--<div class="clear"></div>-->

</div>
