<?php
/**
 * @var TYPE_NAME $album
 * @var string    $category_key
 * @var int       $uid
 */
?>
<div id="photos-list">
    <?php foreach ($album['images'] as $pid) { ?>
        <div id="photos-list-item-<?= $pid ?>" class="left acenter" style="width: 250px">
            <div class="mr5" style="background: #eee">
                <div class="p5 aright" style="height: 20px;">
                    <?php if (session::has_credential('admin') || session::get_user_id() == $uid) { ?>
                        <?php if (in_array($category_key, ['covers'])) { ?>
                            <a id="photos-list-item-modify-<?= $pid ?>" class="mr5" href="javascript:void(0);">
                                <img src="/ui/edit2.png" height="12"/>
                            </a>
                        <?php } ?>
                        <a id="photos-list-item-remove-<?= $pid ?>" href="javascript:void(0);">
                            <img src="/ui/delete2.png" height="20"/>
                        </a>
                    <?php } ?>
                </div>
                <div class="pl10 pr10 pb10">
                    <div id="photos-list-item-photo-<?= $pid ?>"
                         style="height: 180px; background: url('/imgserve?pid=<?= $pid ?>&h=180') no-repeat center; cursor: pointer"></div>
                </div>
                <div style="height: 20px;"></div>
            </div>
        </div>
    <?php } ?>
</div>
