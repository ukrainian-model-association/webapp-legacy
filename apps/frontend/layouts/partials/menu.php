<?php

function display_recursive($subtree, $from_db = true)
{
    if (!empty($subtree['children'])) {
        echo '<ul>';
        foreach ($subtree['children'] as $child_id => $child_data) {
            $child_data['title'] = unserialize($child_data['title']);

            if ((isset($child_data['on']) && $child_data['on'] != 1) || $child_data['hidden']) {
                continue;
            }

            echo '<li><a href="' . (($from_db) ? '/page?link=' : '') . $child_data['link'] . '">' . $child_data['title'][session::get('language', 'ru')] . "</a>";
            display_recursive($child_data);
            echo '</li>';
        }
        echo '</ul>';
    }
}

?>

<style type="text/css">
    div.ddsmoothmenu ul:first-child {
        display: table;
        width: 100%
    }

    div.ddsmoothmenu ul li {
        float: none;
        display: table-cell;
        margin: 0px;
        padding: 0px;
    }

    div.invite_button {
        background: #000000;
        height: 31px;
        line-height: 28px;
        font-weight: bold;
        font-size: 14px;
        color: white;
        text-align: center;
        border-left: 1px solid #000000;
        /*box-shadow: -1px 0 0px #E797BA;*/
        text-transform: uppercase;
    }

    div.invite_button:hover {
        background-color: #212121;
        /*background: url('/buttons/invite/bg2.png') repeat-x;*/
    }
</style>

<div>
    <div class="mb5 ddsmoothmenu left" id="smoothmenu"
         style="background: #000000; width: <?php if (session::is_authenticated()) { ?>827<?php } else { ?>827<?php } ?>px; height: 31px">
        <ul>
            <?php foreach ($menu_items as $menu_item) { ?>
                <?php if ($menu_item["hidden"]) {
    continue;
} ?>
                <li>
                    <a href="<?= $menu_item["href"] ?>"
                       <?php if ($menu_item["href"] == $_SERVER["REQUEST_URI"]) { ?>class="selected"<?php } ?>><?= $menu_item["html"] ?></a>
                    <?php if (isset($menu_item["children"]) && is_array($menu_item["children"])) { ?>
                        <?php display_recursive($menu_item, false); ?>
                    <?php } ?>
                    <?php if (isset($menu_item["static_link"])) { ?>
                        <?php foreach ($menu_tree as $key => $data) { ?>
                            <?php if ($data['link'] != $menu_item['static_link']) {
    continue;
} ?>
                            <?php display_recursive($data); ?>
                        <?php } ?>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    <?php // if(session::is_authenticated()){?>
    <div class="invite_button right pointer" onClick="window.location='/sign/registration'"
         style="width: 193px;"><?= t('Присоединиться') ?></div>
    <!--<div class="invite_button right pointer" onClick ="window.location='/invite'" style="width: 210px;"><?= t('Пригласи подругу') ?></div>-->
    <?php // }?>
    <div class="clear"></div>
</div>

<script type="text/javascript">
  (($) => {
    ddsmoothmenu.init({
      mainmenuid: "smoothmenu", //menu DIV id
      orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
      classname: 'ddsmoothmenu left', //class added to menu's outer DIV
      //customtheme: ["#1c5a80", "#18374a"],
      contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
    });
  })(jQuery)

</script>
