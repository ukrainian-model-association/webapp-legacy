<div class="square_p pl15">
    <div class="left ucase bold"><a href="javascript:void(0);" class="cblack"><?= t("Последние работы моделей") ?></a>
    </div>
    <!--<div class="right fs10"><a href="javascript:void(0);" class="cgray"><?= t('Редактировать') ?></a></div>-->
    <div class="clear"></div>
</div>
<div id="agency-hronology-list" class="mt5 cgray">
    <?php $cnt = 0; ?>
    <?php foreach ($hronology_list as $hronology) { ?>
        <?php if ($hronology['name'] == '') {
    continue;
} ?>
        <div class="pt10 pb10 hide" style="<?php if ($cnt > 0) { ?>border-top: 1px solid #eee<?php } ?>">
            <div class="left" style="width: 280px">
                <div><a href="/profile/?id=<?= $hronology['user_id'] ?>"><?= $hronology['user_name'] ?></a>
                    - <?= t($hronology['category']) ?> :: <a
                            href="<?= t($hronology['link']) ?>"><?= $hronology['name'] ?></a></div>
            </div>
            <div class="right cgray">
                <?php if ($hronology['month'] > 0 && $hronology['year'] > 0) { ?>
                    <?= (ui_helper::get_mounth_list($hronology['month'])) ?>, <?= $hronology['year'] ?>
                <?php } else { ?>
                    &mdash;
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div>
        <?php $cnt++; ?>
    <?php } ?>
    <div class="acenter pt10 pb10" style="border-top: 1px solid #eee">
        <a id="agency-hronology-list-viewmore" href="javascript:void(0);"><?= t('Смотреть ещё') ?></a>
    </div>
</div>
<div id="block-agency-hronology-empty" class="acenter p10 cgray"
     style="border: 1px dotted #ccc;"><?= t('Пусто') ?></div>

<script type="text/javascript">
    $(document).ready(function () {

        if ($('#agency-hronology-list > div').length > 1)
            $('#block-agency-hronology-empty').hide();
        else {
            <?php if (!$access) { ?>
            $('#block-agency-hronology-empty').hide();
            $('#agency-hronology-list')
                .hide()
                .prev()
                .hide();
            <?php } ?>
        }

        var cnt = 10;
        $('#agency-hronology-list-viewmore').click(function () {
            var i = 0
            var cnt_showed = 0;
            $('#agency-hronology-list > div').each(function () {
                if (i < cnt && !$(this).is(':visible')) {
                    $(this)
                        .show()
                        .css({'opacity': 0})
                        .animate({'opacity': 1}, 200);
                    cnt_showed++;
                }

                i++;
            });

            if (i - 1 - cnt > 0)
                $('#agency-hronology-list > div:last-child').show();
            else
                $('#agency-hronology-list > div:last-child').hide();

            cnt += 10;
        });

        $('#agency-hronology-list-viewmore').click();
    });
</script>
