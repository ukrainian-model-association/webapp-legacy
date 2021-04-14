<div class="square_p pl15">
    <div class="left ucase bold"><a href="/agency/albums?id=<?= $agency_id ?>"
                                    class="cblack"><?= t("Фотоальбомы") ?></a></div>
    <div class="right"><a href="/agency/albums?id=<?= $agency_id ?>"><?= t('Смотреть все') ?></a></div>
    <?php if ($access) { ?>
        <div class="right mr10"><a href="/agency/albums?id=<?= $agency_id ?>&show=add_album"><?= t('Добавить') ?></a>
        </div><?php } ?>
    <div class="clear"></div>
</div>
<div id="block-agency-photoalbums" class="mt5">
    <ul>
        <?php foreach ($albums_list as $id) { ?>
            <?php $item = agency_albums_peer::instance()->get_item($id); ?>
            <?php $img_link = ($item['images'][0] > 0) ? "/imgserve?pid=" . $item['images'][0] . "&h=110" : "/no_image.png"; ?>
            <li id="agency-photoalbums-list-item-<?= $id ?>"
                style="background: url('<?= $img_link ?>') no-repeat center">
            </li>
        <?php } ?>
        <li></li>
    </ul>
</div>
<div id="block-agency-photoalbums-empty" class="mt5 acenter p10 cgray hide"
     style="border: 1px dotted #ccc;"><?= t('Пусто') ?></div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#block-agency-photoalbums > ul > li')
            .mouseover(function () {
                $(this).animate({
                    'box-shadow': '0px 0px 10px #444'
                }, 256);
            })
            .mouseout(function () {
                $(this).animate({
                    'box-shadow': '0px 0px 1px black'
                }, 256);
            })
            .click(function () {
                var id = $(this).attr('id').split('-')[4];
                window.location = '/agency/album?aid=' + id;
            });

        if ($('#block-agency-photoalbums > ul > li').length < 2) {
            $('#block-agency-photoalbums-empty').show();
        }

    });
</script>
