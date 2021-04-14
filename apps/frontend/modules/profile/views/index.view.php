<?php

use App\Component\UI\UI;
use App\UI\Widget\WorksWidget;

/**
 * @var html_render $this
 * @var array $profile
 * @var array $hronologies
 * @var array $smi
 * @var int $user_id
 * @var array $albums
 * @var             $by_code
 * @var array $foreignWorks
 * @var array $newsSmi
 * @var array $works
 */

/** @var profile_index_action $ctrl */
$ctrl = $this->controller;

$context = [
        'profile'      => $profile,
        'chronologies' => $hronologies,
        'smi'          => $smi,
        'foreignWorks' => $foreignWorks,
];
/** @var UI $ui */
$ui = $di
        ->get('ui')
        ->setWorkingDirectory(__DIR__);


$geo = static function ($profile) {
    $country = db::get_row('select * from countries where country_id = :id', [
            'id' => $profile['country']
    ]);
    $city = db::get_row('select * from cities where city_id = :id', [
            'id' => $profile['city']
    ]);

    return <<<HTML
{$city['name_ru']}
HTML;

}

?>

<div class="profile container p-0 pb-5 mt-3">
    <div class="row">
        <div class="col-lg-7 position-relative">
            <?= $ui->render('index/full_name', $context, $di) ?>
            <?= $ui->render('index/deletion_history', $context, $di) ?>
            <?= $ui->render('index/status_type', $context, $di) ?>
            <?= $ui->render('index/birthday', $context, $di) ?>
            <?= $ui->render('index/parameters', $context, $di) ?>

            <div class="my-3">
                <?=$geo($profile)?>
            </div>

            <?php $attr_key_width = 200 ?>
            <?php $attr_val_width = 200 ?>

            <div class="row">
                <div class="col">
                    <?php if (4 !== $profile['type']) { ?><?php //include 'index/location.php'?><?php } else { ?><?php $user_additional_id = user_additional_peer::instance(
                    )->get_list(
                            ['user_id' => $profile['user_id']]
                    ); ?><?php $user_additional = user_additional_peer::instance()->get_item(
                            $user_additional_id[0]
                    ); ?><?php if ($profile['manager_agency_id'] > 0) { ?><?php $agency = agency_peer::instance(
                    )->get_item($profile['manager_agency_id']); ?>
                        <div class="fs12 mt10" style="width: 289px">
                            <div>
                                <!--<span class="cgray"><?= t('Место работы') ?>:</span>-->
                                <span>
                                        <a class="bold fs15" href="/agency/?id=<?= $agency['id'] ?>"><?= $agency['name'] ?></a><?php if ('' !== $user_additional['current_work_place_appointment']) { ?>
                                        <br/><?= $user_additional['current_work_place_appointment'] ?><?php } ?></span>
                            </div>
                        </div>
                    <?php } ?><?php } ?>
                </div>
                <?php if (2 === $profile['type'] || session::has_credential('admin')) { ?>
                    <div class="position-absolute fs10 text-right mr-3" style="right: 130px; top: 10px">
                        <?php if (2 === $profile['type']) { ?><?php if ($profile['registrator'] > 0 && !$profile['del'] && !$profile['active'] && filter_var(
                                        $profile['email'],
                                        FILTER_VALIDATE_EMAIL
                                )) { ?>
                            <div>
                                <a class="cgray" href="javascript:void(0);" onclick="inviteUser()"><?= t(
                                            'Пригласить'
                                    ) ?></a>
                                <script type="application/javascript">
                                    const inviteUser = () => {
                                        $.post('/adminka/user_manager', {
                                            'act': 'send_invitation',
                                            'user_id': <?= $profile['user_id'] ?>,
                                        }, function (resp) {
                                            if (resp.success) $('#invcount').html('(' + resp.inv_count + ')');
                                        }, 'json');
                                    };
                                </script>
                                <span id="invcount" class="cgray">
										<?= (db_key::i()->exists(
                                                'invitations_byadmin_'.$profile['user_id']
                                        )) ? '('.db_key::i()->get(
                                                        'invitations_byadmin_'.$profile['user_id']
                                                ).')' : '(0)' ?>
									</span>
                            </div>
                        <?php } ?><?php if (!$profile['del'] && !$profile['active'] && filter_var(
                                        $profile['email'],
                                        FILTER_VALIDATE_EMAIL
                                ) && 2 === (int) $profile['approve']) { ?>
                            <div>
                                <a class="cgray" href="javascript:void(0);" onclick="inviteUser()"><?= t(
                                            'Пригласить'
                                    ) ?></a>
                                <script type="application/javascript">
                                    const inviteUser = () => {
                                        $.post('/adminka/user_manager', {
                                            'act': 'send_invitation_final',
                                            'user_id': <?= $profile['user_id'] ?>,
                                        }, function (resp) {
                                            if (resp.success) {
                                                $('#invcount').html('(' + resp.inv_count + ')');
                                            }
                                        }, 'json');
                                    };
                                </script>
                                <span id="invcount" class="cgray">
										<?= (db_key::i()->exists(
                                                'invitations_registred_'.$profile['user_id']
                                        )) ? '('.db_key::i()->get(
                                                        'invitations_registred_'.$profile['user_id']
                                                ).')' : '(0)' ?>
									</span>
                            </div>
                        <?php } ?><?php if (!$profile['del'] && !$profile['active'] && filter_var(
                                        $profile['email'],
                                        FILTER_VALIDATE_EMAIL
                                ) && 1 === $profile['approve']) { ?>
                            <div>
                                <a class="cgray" href="javascript:void(0);" onclick="$.post('/adminka/user_manager',{'act':'invite_in_work_model', 'user_id': <?= $profile['user_id'] ?>}, function(resp){if(resp.success) $('#invcount').html('('+resp.inv_count+')') },'json');"><?= t(
                                            'Пригласить'
                                    ) ?></a> <span id="invcount" class="cgray">
										<?= (db_key::i()->exists(
                                                'invite_in_work_model_'.$profile['user_id']
                                        )) ? '('.db_key::i()->get(
                                                        'invite_in_work_model_'.$profile['user_id']
                                                ).')' : '(0)' ?>
									</span>
                            </div>
                        <?php } ?><?php } else { ?><?php if ($profile['registrator'] > 0 && !$profile['del'] && !$profile['active'] && filter_var(
                                        $profile['email'],
                                        FILTER_VALIDATE_EMAIL
                                )) { ?>
                            <div>
                                <a class="cgray" href="javascript:void(0);" onclick="inviteUser()">Пригласить</a>
                                <script type="application/javascript">
                                    const inviteUser = () => {
                                        $.post('/adminka/umanager', {
                                            'act': 'send_mail',
                                            'alias': 'invite_nomodels',
                                            'uid': <?= $profile['user_id'] ?>,
                                        }, function (response) {
                                            if (response.success) {
                                                $('#invcount').html('(' + response.invcount + ')');
                                            }
                                        }, 'json');
                                    };
                                </script>
                                <span id="invcount" class="cgray">
										(<?= (db_key::i()->exists(
                                            'invite_nomodels_'.$profile['user_id']
                                    )) ? db_key::i()->get('invite_nomodels_'.$profile['user_id']) : 0 ?>)
									</span>
                            </div>
                        <?php } ?><?php } ?>
                        <?php if (session::is_authenticated() && (session::get_user_id(
                                        ) === $profile['user_id'] || session::has_credential('admin'))) { ?>
                            <div>
                                <a class="cgray fs12" href="/profile/edit?id=<?= $profile['user_id'] ?>"><?= t(
                                            'Редактировать'
                                    ) ?></a><br/>
                                <?php if ((session::has_credential('amu') || session::has_credential(
                                                        'superadmin'
                                                )) || $profile['can_write']) { ?>
                                    <!--<a class="cgray fs12" href="/messages?receiver=--><?php //= $profile['user_id']?><!--">--><?php //= t('Написать')?><!--</a>-->
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <?php if (session::has_credential('admin')) { ?>
                            <div>
                                <a class="cgray hide" href="/polls/history?user_id=<?= $user_id ?>">*<?= t(
                                            'История голосования'
                                    ) ?></a>
                            </div>
                        <?php } ?>
                        <a class="cgray" id="adminka-remove-remove-item-<?= $profile['user_id'] ?>" href="javascript:void(0);">*<?= t(
                                    'Удалить'
                            ) ?></a><br> <span class="cgray fs13"><?= date('d.m.Y', $profile['created_ts']) ?></span>

                        <?php if (session::has_credential('admin')) { ?><?php if ($profile['del']) { ?>
                            <a class="cgray" id="adminka-remove-remove-item-<?= $profile['user_id'] ?>" href="javascript:void(0);">*<?= t(
                                        'Удалить безвозвратно'
                                ) ?></a><br/>
                        <a class="cgray" id="adminka-remove-restore-item-<?= $profile['user_id'] ?>" href="javascript:void(0);">*<?= t(
                                'Восстановить'
                        ) ?></a><?php } ?>

                            <script>
                                $('#adminka-reserv').click(function () {
                                    if (confirm('Вы действительно хотите отправить профиль в резерв?')) {
                                        $.post('/profile', {
                                            'id': <?=$user_id?>,
                                            'act': 'to_reserv',
                                        }, function (response) {
                                            if (response.success)
                                                window.location = '/profile?id=<?=$user_id?>';
                                        }, 'json');
                                    }
                                });

                                $('a[id*=\'adminka-remove-\']').click(function () {
                                    var id = $(this).attr('id').split('-')[4];
                                    var act = $(this).attr('id').split('-')[2];
                                    if (confirm("<?=t('Вы уверены')?>?")) {
                                        $.post('/adminka/user_manager?act=remove', {
                                            'act': act,
                                            'user_id': id,
                                        }, function (data) {
                                            if (data.redirect) window.location = data.redirect;
                                            else if (data.success) window.location = window.location;
                                            else console.log(data);
                                        }, 'json');
                                    }
                                });
                            </script>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <?php if (4 !== $profile['type']) { ?>
                <!-- START RATING -->
                <?php //include 'index/rating.php'?>
                <!-- END RATING -->
            <?php } ?>

            <?= $ui->render('index/admin', $context, $di) ?>
            <?= $ui->render('index/contacts', $context, $di) ?>

            <?php $user_additional_id = user_additional_peer::instance()->get_list(
                    ['user_id' => $profile['user_id']]
            ); ?>
            <?php $user_additional = user_additional_peer::instance()->get_item($user_additional_id[0]); ?>

            <?php if (in_array($profile['type'], [2, 4], true)) { ?>
                <!-- START SHORT INFORMATION -->
                <?php include 'index/info.php' ?>
                <!-- END SHORT INFORMATION -->
            <?php } ?>

            <?php if (!empty($user_additional['about_self'])) { ?>
                <div class="container px-0">
                    <div class="row">
                        <div class="col flex-grow-1 pt-0 pb-1">
                            <a class="square" data-toggle="button" href="javascript:void(0);">О себе</a>
                        </div>

                    </div>
                    <hr>
                    <div class="mt-1" role="contentinfo">
                        <?= $user_additional['about_self'] ?>
                    </div>
                </div>
            <?php } ?>

            <!-- START BLOG -->
            <!--<div class="mt20 blog fs12 cblack">
                <div class="title">
                    <div class="left image">
                        <img src="/square_b.png" />
                    </div>
                    <div class="left ml5 bold ucase">
                        Блог
                    </div>
                    <div class="clear"></div>
                </div>
                <//!--START BLOG ITEMS --//>
                <div class="item mt5">
                    <div class="fs20">
                        <a class="title" href="/profile">Lorem ipsum dolor sit</a>
                    </div>
                    <div class="italic fs11 lcase" style="color: #aeb7c9">19 января</div>
                    <div>Consectetur adipiscing elit. Donec tincidunt risus aliquet nibh dictum mol...</div>
                </div>
                <div class="mt5">
                    <div class="fs20">
                        <a href="/profile" style="color: #5c7fc7">Lorem ipsum dolor sit</a>
                    </div>
                    <div class="italic fs11 lcase" style="color: #aeb7c9">19 января</div>
                    <div>Consectetur adipiscing elit. Donec tincidunt risus aliquet nibh dictum mol...</div>
                </div>
                <//!-- END BLOG ITEMS --//>
                <div class="mt10 all">
                    <a href="/profile">Все 40 записей</a>
                </div>
            </div>-->
            <!-- END BLOG -->

            <!-- START MESSAGES -->
            <?php if ($profile['can_write'] && (int) $profile['user_id'] === session::get_user_id(
                    )) { ?><?php include 'index/messages.php'; ?><?php } ?>
            <!-- END MESSAGES -->

            <?php //  || session::get_user_id()==$profile['user_id']?>
            <?php if (session::has_credential('admin') && 2 === (int) profile_peer::get_type_by_user(
                            $profile['user_id']
                    )) { ?><?php //include 'index/card.php';?><?php } ?>


            <? //= $ui->render('index/chronology', $context, $di) ?>
            <? //= $ui->render('index/briefcase', ['userId' => session::get_user_id(), 'profile' => $profile]) ?>

            <?php if (2 === $profile['type']) { ?>
                <?= WorksWidget::create($di, ['userId' => session::get_user_id(), 'profile' => $profile]) ?>
                <?= $ui->render('index/ForeignWorksView', $context, $di) ?>
                <?= $ui->render(
                        'index/smi',
                        ['collection' => array_merge($smi, $newsSmi), 'profile' => $profile],
                        $di
                ) ?><?php } ?>
        </div>
        <div class="col-lg-5">

            <?php //if (session::get_user_id() === 4) { ?>
            <?php //foreach ($albums as $key => $value) { ?>
            <!--<h3>--><? //= $key ?><!--</h3>-->
            <!--<div>-->
            <!--<pre>--><? //= var_export($albums[$key], true) ?><!--</pre>-->
            <!--</div>-->
            <?php //} ?>
            <?php //} ?>
            <?= $ui->render('index/photo', $context, $di) ?>
            <? //= $ui->render('index/portfolio', ['images' => $albums['portfolio'][0]['images']], $di) ?>
            <?php //= $html->render('index/works', [], $di)?>

            <?php if (1 !== 1 && 2 === (int) profile_peer::get_type_by_user($profile['user_id'])) { ?>
                <!-- START WORKS -->
                <div class="mt20">
                    <div class="square_p pl15 mb10 fs11">
                        <div class="left ucase bold">
                            <a class="cblack" href="/albums/works?uid=<?= $user_id ?>"><?= t('Работы ') ?></a>
                        </div>
                        <div class="right">
                            <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums/works?uid=<?= $user_id ?>"><?= t(
                                        'Смотреть все'
                                ) ?></a>
                        </div>
                        <?php if (session::get_user_id() === $user_id || session::has_credential('admin')) { ?>
                            <div class="right mr10">
                                <div>
                                    <a class="underline cgray" href="javascript:void(0);" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" onclick="
											if($('#window-categories').is(':visible')) {
												$('#window-categories').animate({
													'opacity': '0'
												}, 256, function(){
													$(this).hide();
												});
											} else {
												$('#window-categories')
													.show()
													.css('opacity', '0')
													.animate({opacity: 1}, 256);
												}
										"><?= t('Добавить работу') ?></a>
                                </div>
                                <div id="window-categories" class="pb10 pl5 pr5 mt5 hide" style="position: absolute; border: 1px solid gray; background: #fff; box-shadow: 0px 0px 5px #aaa">
                                    <?php foreach ($works as $category_key => $work) { ?><?php if (in_array(
                                            $category_key,
                                            ['portfolio']
                                    )) { ?><?php continue; ?><?php } ?>
                                        <div class="pt5">
                                            <?php if (in_array($category_key, ['covers'])) { ?>
                                                <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href='/albums/album?aid=<?= $albums[$category_key][0]['id'] ?>&uid=<?= $user_id ?>&show=add_photo'><?= $work ?></a>
                                            <?php } else { ?>
                                                <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href='/albums?filter=<?= $category_key ?>&uid=<?= $user_id ?>&show=add_album'><?= $work ?></a>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="clear"></div>
                    </div>
                    <?php // if((session::has_credential('admin') || session::get_user_id() == $user_id) && count($works) > 0){?>
                    <div class="fs12">
                        <?php $flag = false; ?>
                        <?php foreach ($works as $category_key => $work) { ?><?php if (in_array(
                                $category_key,
                                ['portfolio', 'contest']
                        )) { ?><?php continue; ?><?php } ?><?php if (count(
                                        $albums[$category_key][0]['images'][0]
                                ) > 0) { ?><?php $flag = true; ?>
                            <div class="left mr10" style="width: 100px;">
                                <div class="acenter" style="height: 32px;">
                                    <?php if (in_array(
                                            $category_key,
                                            ['covers']
                                    )) { ?><?php // $albums_id = user_albums_peer::instance()->get_list(array('user_id' => $user_id, 'category' => $category_key));?>
                                        <a class="underline" href="/albums/album?aid=<?= $albums[$category_key][0]['id'] ?>&uid=<?= $user_id ?>"><?= $work ?>
                                            &nbsp;(<?= count($albums[$category_key][0]['images']) ?>)</a>
                                    <?php } else { ?>
                                        <a class="underline" href="/albums?filter=<?= $category_key ?>&uid=<?= $user_id ?>"><?= $work ?>
                                            &nbsp;(<?= count($albums[$category_key]) ?>)</a>
                                    <?php } ?>
                                </div>
                                <div
                                        <?php if (in_array($category_key, ['covers'])) { ?>
                                            onclick="window.location = '/albums/album?aid=<?= $albums[$category_key][0]['id'] ?>&uid=<?= $user_id ?>';"
                                        <?php } else { ?>
                                            onclick="window.location = '/albums?filter=<?= $category_key ?>&uid=<?= $user_id ?>';"
                                        <?php } ?>
                                        style="cursor: pointer; height: 80px; background: url('/imgserve?pid=<?= $albums[$category_key][0]['images'][0] ?>&h=80') no-repeat center"></div>
                                <div class="acenter">
                                    <?php $name = $albums[$category_key][0]['name'] ?>
                                    <?php if (in_array(
                                            $category_key,
                                            ['covers']
                                    )) { ?><?php $photo = user_photos_peer::instance()->get_item(
                                            $albums[$category_key][0]['images'][0]
                                    ); ?><?php $photo['additional'] = unserialize(
                                            $photo['additional']
                                    ); ?><?php $name = $photo['additional']['journal_name'].' :: '.$photo['additional']['journal_number'].', '.$photo['additional']['journal_year']; ?><?php } ?>
                                    <!--<a class="underline" href='/albums/album?aid=<?= $albums[$category_key][0]['id'] ?>&uid=<?= $user_id ?>'><?= $name ?></a>-->
                                </div>
                            </div>
                        <?php } ?><?php } ?>
                        <?php if (!$flag) { ?>
                            <div class="left acenter cgray" style="width: 580px; height: 57px; background: #eee; padding-top: 45px;">
                                <?= t('Тут еще нет работ') ?>
                            </div>
                        <?php } ?>
                        <div class="clear"></div>
                    </div>
                    <?php // }?>
                </div><!-- END WORKS -->
            <?php } ?>

            <?php if ('1' !== '1' && 2 === (int) profile_peer::get_type_by_user($profile['user_id'])) { ?>
                <!-- START CONTEST -->
                <?php if (session::get_user_id() === $user_id || count($albums['contest']) > 0) { ?>
                    <div class="mt20">
                        <div class="square_p pl15 mb10">
                            <div class="left bold ucase">
                                <a class="cblack" href="/albums?uid=<?= $user_id ?>&filter=contest"><?= t(
                                            'Конкурсы'
                                    ) ?></a>
                            </div>
                            <div class="right">
                                <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums?uid=<?= $user_id ?>&filter=contest"><?= t(
                                            'Смотреть все'
                                    ) ?></a>
                            </div>
                            <?php if (session::get_user_id() === $user_id || session::has_credential('admin')) { ?>
                                <div class="right mr10">
                                    <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums?uid=<?= $user_id ?>&filter=contest&show=add_album"><?= t(
                                                'Добавить альбом'
                                        ) ?></a>
                                </div>
                            <?php } ?>
                            <div class="clear"></div>
                        </div>
                        <?php if (count($albums['contest']) > 0) { ?>
                            <div>
                                <?php foreach ($albums['contest'] as $album) { ?>
                                    <div class="left mr10" style="width: 100px;">
                                        <div onclick="window.location = '/albums/album?aid=<?= $album['id'] ?>&uid=<?= $user_id ?>';" style="cursor: pointer; height: 80px; background: url('/imgserve?pid=<?= $album['images'][0] ?>&h=80') no-repeat center"></div>
                                        <!--<div class="acenter">
											<a class="underline" href='/albums/album?aid=<?= $album['id'] ?>&uid=<?= $user_id ?>'><?= $album['name'] ?></a>
										</div>-->
                                    </div>
                                <?php } ?>
                                <div class="clear"></div>
                            </div>
                        <?php } else { ?>
                            <div class="acenter cgray" style="width: 580px; height: 57px; background: #eee; padding-top: 45px;">
                                <?= t('Тут еще нет фотографий') ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!-- END CONTEST -->
            <?php } ?>

            <?php if (1 !== 1 && 2 === (int) profile_peer::get_type_by_user($profile['user_id'])) { ?>
                <!-- START PHOTO ALBUMS -->
                <?php if (session::get_user_id() === $user_id || count($albums['photos']) > 0) { ?>
                    <div class="mt20">
                        <div class="square_p pl15 mb10">
                            <div class="left bold ucase">
                                <a class="cblack" href="/albums?uid=<?= $user_id ?>"><?= t('Фотографии') ?></a>
                            </div>
                            <div class="right">
                                <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums?uid=<?= $user_id ?>"><?= t(
                                            'Смотреть все'
                                    ) ?></a>
                            </div>
                            <?php if (session::get_user_id() === $user_id || session::has_credential('admin')) { ?>
                                <div class="right mr10">
                                    <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums?uid=<?= $user_id ?>&show=add_album"><?= t(
                                                'Добавить альбом'
                                        ) ?></a>
                                </div>
                            <?php } ?>
                            <div class="clear"></div>
                        </div>
                        <?php if (count($albums['photos']) > 0) { ?>
                            <div>
                                <?php foreach ($albums['photos'] as $album) { ?>
                                    <div class="left mr10" style="width: 100px;">
                                        <div onclick="window.location = '/albums/album?aid=<?= $album['id'] ?>&uid=<?= $user_id ?>';" style="cursor: pointer; height: 80px; background: url('/imgserve?pid=<?= $album['images'][0] ?>&h=80') no-repeat center"></div>
                                        <!--<div class="acenter">
											<a class="underline" href='/albums/album?aid=<?= $album['id'] ?>&uid=<?= $user_id ?>'><?= $album['name'] ?></a>
										</div>-->
                                    </div>
                                <?php } ?>
                                <div class="clear"></div>
                            </div>
                        <?php } else { ?>
                            <div class="acenter cgray" style="width: 580px; height: 57px; background: #eee; padding-top: 45px;">
                                <?= t('Тут еще нет фотографий') ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <!-- END PHOTO ALBUMS -->
            <?php } ?>

            <?php if (1 !== 1 && session::has_credential('admin')) { ?>
                <div class="mt-3">
                    <div class="square_p pl15 mb10">
                        <div class="left bold ucase">
                            <a class="cblack" href="/albums/album?uid=<?= $user_id ?>&filter=deleted"><?= t(
                                        'Админский альбом'
                                ) ?></a>
                        </div>
                        <div class="right fs11">
                            <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums/album?uid=<?= $user_id ?>&filter=deleted"><?= t(
                                        'Смотреть все'
                                ) ?></a>
                        </div>
                        <div class="right mr10 fs11">
                            <a class="underline cgray" onmouseover="$(this).css('color', 'black')" onmouseout="$(this).css('color', 'gray')" href="/albums/album?uid=<?= $user_id ?>&filter=deleted&show=add_photo"><?= t(
                                        'Добавить фото'
                                ) ?></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php if (count($albums['admin']) > 0) { ?>
                        <div>
                            <?php foreach ($albums['admin'] as $pid) { ?>
                                <div class="left mr10" style="width: 100px;">
                                    <div onclick="window.location = '/albums/album?uid=<?= $user_id ?>&filter=deleted';" style="cursor: pointer; height: 80px; background: url('/imgserve?pid=<?= $pid ?>&h=80') no-repeat center"></div>
                                </div>
                            <?php } ?>
                            <div class="clear"></div>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-dark m-0 border-0 rounded-0 fs12 text-center text-muted" role="alert">
                            Тут еще нет работ
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<script src="/public/js/app/profile/index.js" type="application/javascript"></script>

<?php if ($by_code) { ?><?php include 'index/login_by_code_form.php'; ?><?php } ?>
