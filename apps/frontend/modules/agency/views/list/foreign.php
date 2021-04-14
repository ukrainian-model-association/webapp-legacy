<?php
/**
 * @var array $context
 * @var array $agenciesWithoutLocation
 */

?>

<div class="small-title square_p font-weight-bold text-uppercase text-dar mt-3">
    <?= t('Иностранные агенства') ?>
</div>

<div class="grid-container ">
    <div class="agency_index" style="">
        <?php foreach ($context as $country) { ?>
            <div class="agency-group">
                <h3 class="p-0 m-0 mb-2 text-nowrap">
                <span class="flag-icon flag-icon-<?= $country['code'] ?>"
                    style="font-size: 50%"></span> <span class="text-uppercase h6"><?= $country['name'] ?></span>
                </h3>
                <ul style="margin-left: 28px">
                    <?php foreach ($country['cities'] as $city) { ?>
                        <li class="p-0">
                            <h6 name="clickable" class="m-0 text-muted"
                                style="width: 100%; font-size: 14px; cursor: pointer"><?= $city['name'] ?></h6>
                            <ul class="d-none ml-2">
                                <?php foreach ($city['agencies'] as $agency) { ?>
                                    <li class="m-0 p-0">
                                        <a href="/agency/?id=<?= $agency['id'] ?>"
                                            class="s-1"><?= $agency['name'] ?></a><span class="ml-1 text-pink"> <?= $agency['members_count'] > 0 ? $agency['members_count'] : '' ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('div[id^=\'agency-models-item\']')
            .mouseover(function () {
                var id = $(this).attr('id').split('-')[3];
                $('#agency-models-item-tooltip-' + id).show();
            })
            .mouseout(function () {
                var id = $(this).attr('id').split('-')[3];
                $('#agency-models-item-tooltip-' + id).hide();
            })
            .mousemove(function (evn) {
                var id = $(this).attr('id').split('-')[3];

                var x = evn.clientX + $(window).scrollLeft() + 16;
                var y = evn.clientY + $(window).scrollTop() + 16;

                $('#agency-models-item-tooltip-' + id)
                    .css({
                        'left': x + 'px',
                        'top': y + 'px',
                    });
            })
            .click(function () {
                var id = $(this).attr('id').split('-')[3];
                var newWindow = window.open('/profile/?id=' + id, '_blank');
                newWindow.focus();
            });

        $('h6[name="clickable"]').click((e) => {
            e.target.classList.toggle('text-pink');
            const ul = $(e.target).next()[0];
            if (ul.classList.contains('d-none')) {
                ul.classList.remove('d-none');

            } else {
                ul.classList.add('d-none');
            }
        });
    });
</script>

<style>
    .agency_index {
        -moz-column-count: 5;
        -webkit-column-count: 5;
        column-count: 5;
        width: 100%;
    }
</style>

