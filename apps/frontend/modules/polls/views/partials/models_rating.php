<div class="models_rating_box">
    <div class="small-title left square_p pl10 mt10 mb10">
        <a href="/"><?= t('самые популярные') ?></a>
    </div>
    <div class="clear"></div>
    <table style="width: 100%;" id="models_rating_table">
        <tr>
            <?php $fp = db::get_row('SELECT user_id, pid, ph_crop, first_name, last_name FROM user_data WHERE user_id=:uid', ['uid' => $list[0]['user_id']]); ?>
            <?php $crop = unserialize($fp['ph_crop']); ?>
            <td rowspan="2" style="vertical-align: top; text-align: center; padding: 0">
                <div style='text-align: center;' class='fs18 cpurple'><span class="bold">1</span> место</div>
                <a href="/profile?id=<?= $list[0]['user_id'] ?>">
                    <img data-avatar="<?= $list[0]['user_id'] ?>" style='width: 318px' src='/imgserve?pid=<?= $fp['pid'] ?>&w=<?= $crop['w'] ?>&h=<?= $crop['h'] ?>&x=<?= $crop['x'] ?>&y=<?= $crop['y'] ?>&z=crop' alt="">
                </a>
                <div class="fs20" style="position: relative; margin-left: 0; border-bottom: 1px solid #ccc; width: 318px">
                    <div class="fs20 bold" style="position: absolute; right: 5px; bottom: 5px; color: white; text-shadow: 0 0 3px black">
                        <img src="/rating_hand.png" alt="/rating_hand.png"> <?= $list[0]['sum'] ?>
                    </div>
                </div>
                <div data-tooltip="<?= $list[0]['user_id'] ?>"
                     class="hide"
                     style="<?= implode('; ', [
                         'position: absolute',
                         'background: black',
                         'color: white',
                         'border-radius: 5px',
                         'font-size: 11px',
                         'padding: 5px 10px',
                     ]) ?>"><?= profile_peer::get_name($fp) ?></div>
            </td>
            <?php generate_cols($list, 1, 5, '', ['width: 160px;', 'width: 16px;'], ['fs22', 'fs14', 'fs12', 'fs17', 'mt' => 10]); ?>
        </tr>
        <tr>
            <td colspan="8">
                <table style="width: 100%;">
                    <tr>
                        <?php generate_cols($list, 5, 10, '', ['width: 130px;', 'width: 16px;'], ['fs20', 'fs12', 'fs10', 'fs15', 'mt' => 8]); ?>
                    </tr>
                </table>
            </td>

        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <?php generate_cols($list, 10, 20, '', ['width: 90px;', 'width: 10px;'], ['fs16', 'fs12', 'fs9', 'fs13', 'mt' => 4]); ?>
        </tr>
        <tr>
            <?php generate_cols($list, 20, 40, '', ['width: 90px;', 'width: 10px;'], ['fs16', 'fs12', 'fs9', 'fs13', 'mt' => 4]); ?>
        </tr>
    </table>
    <div class="clear"></div>
    <div class="right" style="margin-top: 25px; margin-bottom: 25px;">
        <a href='/polls/rating?type=models-full' style='text-decoration: underline; padding-right: 10px; font-style: italic;' class="arrow_p right fs12"><?= t('Смотреть весь рейтинг') ?></a>
    </div>
    <div class="clear"></div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('img[data-avatar]')
            .mouseout(function (e) {
                $(e.target.closest('td').querySelector('div[data-tooltip]')).hide();
            })
            .mousemove(function (e) {
                $(e.target.closest('td').querySelector('div[data-tooltip]'))
                    .show()
                    .css({
                        'top': e.pageY + 16,
                        'left': e.pageX + 16,
                        'zIndex': '999'
                    });
            })

    });
</script>