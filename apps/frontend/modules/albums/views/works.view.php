<div class="fs11">

    <div class="p5 mb10" style="background: #eee; border-top: 1px solid #ccc">
        <div class="left">
            <a href="/profile?id=<?= $uid ?>"><?= profile_peer::get_name($profile) ?></a>
        </div>
        <div class="clear"></div>
    </div>

    <div class="aleft square_p pl15 mt20">
        <div class="left ucase bold cblack">
            <?= t('Работы') ?>
        </div>
        <div class="clear"></div>
    </div>

    <?php $g_counter = 0 ?>
    <?php foreach ($categories as $category_key => $category) { ?>
        <?php include 'works/work.php'; ?>
        <?php $g_counter++ ?>
    <?php } ?>

</div>
