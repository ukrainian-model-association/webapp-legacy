<?php include 'index/viewer.php'; ?>

<?php foreach ($boxes as $box) { ?>

    <?php if (!count($box["updates"])) {
        continue;
    } ?>

    <div class="small-title square_p pl10 mb10 mt10">
        <a href="/updates?category=<?= $box["category"] ?>"><?= user_albums_peer::get_category($box["category"]) ?></a>
    </div>
    <div id="updates-photos">
        <?php $cnt = 0; ?>
        <?php rsort($box["images"], SORT_NUMERIC) ?>
        <?php for ($i = 0; $i < $count_imgs_per_category; $i++) { ?>
            <div class="left<?php if ($cnt < 5) { ?> mr30<?php } ?>" style="width: 140px;">
                <div id="updates-photo-<?= $box["images"][$i] ?>" category="<?= $box["category"] ?>"
                     uid="<?= $users[$box["images"][$i]] ?>"
                     style="background: url('/imgserve?pid=<?= $box["images"][$i] ?>&h=180') center; height: 180px; cursor: pointer"></div>
                <?php $user_data = profile_peer::instance()->get_item($users[$box["images"][$i]]); ?>
                <div class="acenter bold fs12 mt10" style="height: 40px">
                    <a href="/profile?id=<?= $users[$box["images"][$i]] ?>">
                        <?= profile_peer::get_name($user_data, "&fn") ?> <span class="ucase"><?= profile_peer::get_name(
                                $user_data,
                                "&ln"
                            ) ?></span>
                    </a>
                </div>
            </div>
            <?php if ($cnt == 5) { ?>
                <?php $cnt = 0; ?>
            <?php } else { ?>
                <?php $cnt++ ?>
            <?php } ?>
        <?php } ?>
        <div class="clear"></div>
    </div>
<?php } ?>

<script type="text/javascript">
  $(document).ready(function () {
    $('div[id^=\'updates-photo-\']').click(function () {
      var id = $(this).attr('id').split('-')[2];
      var category = $(this).attr('category');
      var uid = $(this).attr('uid');

      $.post('/updates', {
        'act': 'get_description',
        'id': id,
        'category': category,
        'uid': uid,
      }, function (response) {
        var description = {};
        description[id] = { html: response.html };
        init_album_viewer([id], id, description);
      }, 'json');

//			init_album_viewer([id]);
    });
  });
</script>
