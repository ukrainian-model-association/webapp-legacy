<div class="small-title square_p pl10 mt10 mb10">
    <a href="/journals"><?= t('Журналы') ?></a>
</div>

<div>
    <?php $cnt = 0; ?>
    <?php foreach ($countries as $key => $value) { ?>
        <div class="mb-3 mr-3 left" style="width: 250px;">
            <div id="country-<?= $key ?>" class="bold" style="cursor: pointer">
                <?= profile_peer::get_location(['country' => $key]) ?>
            </div>
            <div id="block-journals-<?= $key ?>" class="pt5 pb5 pl10">
                <?php foreach ($value as $id) { ?>
                    <?php $journal = journals_peer::instance()->get_item($id); ?>
                    <div class="row">
                        <a class="fs18 col" href="/journals/?id=<?= $id ?>"><?= $journal['name'] ?></a>
                        <?php if ($journal['models_count'] > 0) { ?>
                            <span class="col-4 text-right text-muted">
                                <span class="badge badge-secondary"><?= $journal['models_count'] ?></span>
                            </span>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if ($cnt > 2) { ?>
            <div class="clear"></div>
            <?php $cnt = 0; ?>
        <?php } else { ?>
            <?php $cnt++ ?>
        <?php } ?>
    <?php } ?>
    <div class="clear"></div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
//		$("div[id^='country-']").click(function(){
//			var id = $(this).attr("id").split("-")[1];
//			
//			if($("#block-journals-"+id).is(":visible"))
//			{
//				$("#block-journals-"+id)
//					.animate({
//						"opacity": 0
//					}, 256, function(){
//						$(this).hide();
//					})
//			}
//			else
//			{
//				$("#block-journals-"+id)
//					.show()
//					.css("opacity", 0)
//					.animate({
//						"opacity": 1
//					}, 256);
//			}
//				
//			
//		});
    });
</script>