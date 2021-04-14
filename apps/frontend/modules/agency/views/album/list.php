<div id="images-list">

    <?php $counter = 0; ?>
    <?php $mt = 0; ?>
    <?php foreach ($agency_album['images'] as $pid) { ?>
        <?php // $album = agency_albums_peer::instance()->get_item($pid);?>

        <?php if ($counter == 0) { ?>
            <div class="mt<?= $mt ?>">
        <?php } ?>

        <div id="images-list-item-<?= $pid ?>" class="left acenter" style="width: 250px;">
            <div class="p5">
                <?php if ($access) { ?>
                    <div class="aright mb5">
                        <a id="photos-list-item-remove-<?= $pid ?>" href="javascript:void(0);">
                            <img src="/ui/delete2.png" style="height: 20px; ">
                        </a>
                    </div>
                <?php } ?>
                <div id="photos-list-item-photo-<?= $pid ?>"
                     style="background: url('/imgserve?pid=<?= $pid ?>&h=200') no-repeat center; width: 240px; height: 200px; cursor: pointer"></div>
            </div>
        </div>

        <?php if ($counter == 3) { ?>
            <div class="clear"></div>
            </div>
            <?php $counter = 0; ?>
            <?php $mt = 10; ?>
        <?php } else { ?>
            <?php $counter++ ?>
        <?php } ?>

    <?php } ?>

    <?php if ($counter <= 3) { ?>
    <div class="clear"></div>
</div>
<?php } ?>

</div>
