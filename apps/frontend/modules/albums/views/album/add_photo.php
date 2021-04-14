<?php
/**
 * @var string $category_key
 * @var int    $aid
 */
?>
<div id="blind-wait" class="fs12 hide" style="position: absolute; background: #fff; opacity: 0.8; text-align: center;">
    <div class="p20" style="margin-top: 128px;">
        <div>
            <img src="/loading2.gif"/>
        </div>
        <div>
            Идет загрузка. Ждите...
        </div>
    </div>
</div>
<div>
    <form id="add_photo" action="/albums/album" method="post">

        <div class="acenter mb10 hide">
            <input type="text" id="act" value="add_photo"/>
        </div>

        <?php if (in_array($category_key, ['covers'])) { ?>
            <?php include 'forms/' . $category_key . '.php'; ?>
        <?php } else { ?>
            <?php include 'forms/default.php'; ?>
        <?php } ?>

        <div class="my-1 text-center">
            <input type="button" id="submit" value="Сохранить"/>
            <?php if ('deleted' !== request::get_string('filter')) { ?>
                <input type="button" id="cancel" value="Отмена"/>
            <?php } else { ?>
                <input type="button" id="close" value="Закрыть"/>
            <?php } ?>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        const form = new Form('add_photo');

        form.data = {
//			'act': 'add_photo',
            'aid': '<?=$aid?>',
        };

        form.onSuccess = function (response) {
            if (response.success) {
                window.location = '/albums/album?aid=' + response.aid + '&uid=<?=$uid?>';
            }
        };

        $('#window-add-photo #submit').click(function () {
            $('#blind-wait').width($('#window-add-photo').width());
            $('#blind-wait').height($('#window-add-photo').height());
            $('#window-add-photo #submit').attr('disabled', true);
            $('#blind-wait').show();
            form.send();
        });

        $('#window-add-photo #close').click(function () {
            window.location = '/albums/album?uid=<?=$uid?>&filter=deleted';
        });

    });
</script>
