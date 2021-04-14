<?php

/**
 * @param array                           $context
 * @param ServiceContainer $di
 *
 * @return string
 */

use App\Component\ServiceContainer;

return static function ($context, $di) {
    $profile = $context['profile'];
    $imgSrc  = '/no_image.png';

    if ((int)$profile['pid'] > 0) {
        $imgSrc = sprintf('/imgserve?pid=%s&w=480', $profile['pid']);
    }

    return sprintf('<div id="avatar"><img src="%s" class="img-fluid w-100 rounded" alt="Avatar"></div>', $imgSrc);
};

?>
<div class="fs12 acenter">
    <? $crop = unserialize($profile["ph_crop"]) ?>
    <div class="pt15 pb15" style="background: #eee; border: 1px solid #ccc">

        <div id="profile-photo" style="background: url('<? if ($profile["pid"]) { ?>/imgserve?pid=<?= $profile["pid"] ?>&h=600<? } else { ?>/no_image.png<? } ?>') no-repeat center; height: 600px"></div>

        <? if (voting_peer::can_vote($profile['user_id'], voting_peer::MODEL_RATING) && 0) { ?>
            <center>
                <div class="pointer mt15" style="background: #000000; width: 200px; color: white;" onClick="App.vote('<?= $profile["user_id"] ?>','<?= voting_peer::MODEL_RATING ?>',1,'model_rating_votes'); $('#rating_hand').removeAttr('onClick').removeClass('pointer'); $(this).remove();">
                    <img src="/rating_white.png" onclick=""/>
                    <span class="ml5 fs18" style="line-height: 33px;">
							Голосовать
						</span>
                </div>
            </center>
        <? } ?>
    </div>
</div>
