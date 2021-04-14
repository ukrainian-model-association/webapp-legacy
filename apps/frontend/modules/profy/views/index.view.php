<h2><?= $title ?></h2>
<ul <?= $ul ?>>
    <?php foreach ($list as $item) { ?>
        <li class="list-group-item p-1">
            <?php if (42 === $item['status']) { ?><?php include 'index/agent.php' ?><?php } else { ?><?php include 'index/default.php' ?><?php } ?>
        </li>
    <?php } ?>
</ul>
