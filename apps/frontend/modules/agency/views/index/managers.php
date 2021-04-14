<div class="square_p pl15">
    <div class="left ucase bold"><a href="javascript:void(0);" class="cblack"><?= t("Менеджеры") ?></a></div>
    <!--<div class="right"><a href="javascript:void(0);" class="cgray">[<?= t('Редактировать') ?>]</a></div>-->
    <div class="clear"></div>
</div>

<?php $jobPosition = [
        1 => 'Директор',
        2 => 'Букер',
        3 => 'Международный букер',
        4 => 'Скаут',
]; ?>
<div id="block-agency-managers" class="mt10">
    <?php foreach ($managers_list as $m) { ?><?php $item = profile_peer::instance()->get_item($m['user_id']); ?>

        <div>
            <img src="/imgserve.php?pid=<?= $item['pid'] ?>" class="img-thumbnail float-left" style="height: 50px" alt="">
            <div class="d-inline-block" style="padding-top: 10px">
                <a class="btn-link text-black-50 text-uppercase font-weight-bold" href="/profile?id=<?= $m['user_id'] ?>"><?= profile_peer::get_name(
                            $item
                    ) ?></a> <div class="text-muted" style="margin-top: -6px"><?= $jobPosition[$m['job_position']] ?></div>
            </div>
        </div>
    <?php } ?>
</div>
<div id="block-agency-managers-empty" class="acenter p10 cgray" style="border: 1px dotted #ccc;"><?= t('Пусто') ?></div>
<div class="mt5 cgray"></div>
<script type="text/javascript">
    $(document).ready(function () {
        if ($('#block-agency-managers > div').length > 0)
            $('#block-agency-managers-empty').hide();
    });
</script>
