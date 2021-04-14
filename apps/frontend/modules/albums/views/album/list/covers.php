<div class="aleft square_p pl15 mt20">
    <div class="left ucase bold cblack">
        <?= t('Работы') ?>
    </div>
    <div class="clear"></div>
</div>
<div class="mb30">
    <div class="left bold fs18">
        <a href="/albums/album?aid=<?= $aid ?>&uid=<?= $uid ?>"><?= t('Обложки') ?></a>
    </div>
    <div class="clear"></div>
</div>

<div id="photos-list">

    <?php $counter = 0; ?>
    <?php $pt = 0; ?>
    <?php $pb = 30; ?>
    <?php $orient = 'left'; ?>
    <?php $row_style = ''; ?>
    <?php $item_style = ''; ?>
    <?php foreach ($album['images'] as $pid) { ?>

        <?php $photo = user_photos_peer::instance()->get_item($pid); ?>
        <?php $photo['additional'] = unserialize($photo['additional']); ?>
        <?php $name = $photo['additional']['journal_name'] . " №" . $photo['additional']['journal_number'] . ', ' . mb_strtolower(date_peer::instance()->get_month($photo['additional']['journal_month'])) . ' ' . $photo['additional']['journal_year']; ?>

        <?php if ($counter == 0) { ?>
            <div class="pt<?= $pt ?>" style="<?= $row_style ?>">
        <?php } ?>

        <div id="photos-list-item-<?= $pid ?>" class="<?= $orient ?> acenter" style="<?= $item_style ?>">
            <div>
                <?php if (session::get_user_id() == $uid || session::has_credential('admin')) { ?>
                    <div class="aright">
                        <?php if (in_array($category_key, ['covers'])) { ?>
                            <a id="photos-list-item-modify-<?= $pid ?>" class="mr5" href="javascript:void(0);">
                                <img src="/ui/edit2.png" height="12"/>
                            </a>
                        <?php } ?>
                        <a id="photos-list-item-remove-<?= $pid ?>" href="javascript:void(0);">
                            <img src="/ui/delete2.png" height="20"/>
                        </a>
                    </div>
                <?php } ?>
                <div>
                    <div class="left mr10 pb<?= $pb ?>" style="width: 270px; border: 1px solid #eee;">
                        <div id="photos-list-item-photo-<?= $pid ?>"
                             style="height: 355px; background: url('/imgserve?pid=<?= $pid ?>&h=420') no-repeat center; cursor: pointer;"></div>
                    </div>
                    <div class="left aleft" style="width: 189px">
                        <div class="mb5 fs18 bold" style="color: #000000">
                            <a href='javascript:void(0);'
                               onclick="$('#photos-list-item-photo-<?= $pid ?>').click()"><?= $photo['name'] ?></a>
                        </div>
                        <div>
                            <?php if ($photo['additional']['photographer'] != '') { ?>
                                <span class="cgray"><?= t('Фотограф') ?>: </span>
                                <span><?= $photo['additional']['photographer'] ?></span><br/>
                            <?php } ?>
                            <?php if ($photo['additional']['visagist'] != '') { ?>
                                <span class="cgray"><?= t('Визажист') ?>: </span>
                                <span><?= $photo['additional']['visagist'] ?></span><br/>
                            <?php } ?>
                            <?php if ($photo['additional']['stylist'] != '') { ?>
                                <span class="cgray"><?= t('Стилист') ?>: </span>
                                <span><?= $photo['additional']['stylist'] ?></span><br/>
                            <?php } ?>
                            <?php if ($photo['additional']['designer'] != '') { ?>
                                <span class="cgray"><?= t('Одежда') ?>: </span>
                                <span><?= $photo['additional']['designer'] ?></span><br/>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>

        <?php if ($counter == 1) { ?>
            <div class="clear"></div>
            </div>
            <?php $item_style = ''; ?>
            <?php $orient = 'left'; ?>
            <?php $counter = 0; ?>
            <?php $pt = 30; ?>
            <?php $row_style = 'padding-top: 30px; border-top: 1px solid #eee; '; ?>
        <?php } else { ?>
            <?php $item_style = 'padding-left: 30px; border-left: 1px solid #eee;'; ?>
            <?php $orient = 'right'; ?>
            <?php $counter++ ?>
        <?php } ?>

    <?php } ?>

    <?php if ($counter <= 1) { ?>
        <div class="clear"></div>
    <?php } ?>
</div>
