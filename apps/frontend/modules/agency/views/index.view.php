<?php

use Agency\Profile\General;

require __DIR__.'/index/General.php';

?>
<div class="fs12 mt10" style="width: 1000px;">

    <div class="left mr20" style="width: 370px;">

        <?= General::create()
                ->setAgency($agency)
                ->setAccess($access)
                ->render() ?>


        <!-- START ABOUT -->
        <?php if ($access || $agency['about'] != '') { ?>
            <div class="mt20">
                <?php include 'index/about.php'; ?>
            </div>
        <?php } ?>
        <!-- END ABOUT -->

        <!-- START MANAGERS -->
        <?php // if (session::has_credential('admin')) { ?>
        <div class="mt20">
            <?php include 'index/managers.php'; ?>
        </div>
        <?php // } ?>
        <!-- END MANAGERS -->

        <!-- START CONTACTS -->
        <div class="mt20">
            <?php include 'index/contacts.php'; ?>
        </div>
        <!-- END CONTACTS -->


        <!-- START HRONOLOGY -->
        <!--<div class="mt20">
            <?php /*include 'index/hronology.php'; */ ?>
        </div>-->
        <!-- END HRONOLOGY -->

    </div>


    <div class="left" style="width: 610px;">
        <!-- START MODELS -->
        <div>
            <?php include 'index/models.php'; ?>
        </div>
        <!-- END MODELS -->

        <!-- START PHOTO ALBUMS -->
        <?php /* if($access || count($albums_list) > 0){ */ ?><!--
			<div class="mt10">
				<?php /* include 'index/albums.php'; */ ?>
			</div>
		--><?php /* } */ ?>
        <!-- END PHOTO ALBUMS -->

        <?php // if (in_array(session::get_user_id(), [4, 31, 2323], true)) { ?>
        <!--<div class="mt-1">-->
        <? //= AgencyReviewsWidget::create($di) ?>
        <!--</div>-->
        <?php // } ?>

    </div>

    <div class="clear"></div>

</div>
