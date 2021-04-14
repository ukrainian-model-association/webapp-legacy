<div class="footer">
    <div>
        <div>
            <a href="/">
                <img src="/public/img/logo/footer.svg" alt="Ассоциация моделей Украины" class="w-100"/>
            </a>
        </div>
        <div class="links">
            <?php /** @var array $menu_items */
            foreach ($menu_items as $menuItem) { ?>
                <?php if (!$menuItem["hidden"]) { ?>
                    <a href="<?= $menuItem["href"] ?>"
                       <?php if (0 && $menuItem["href"] === $_SERVER["REQUEST_URI"]) { ?>class="selected"<?php } ?>>
                        <?= $menuItem["html"] ?>
                    </a>
                <?php } ?>
            <?php } ?>
            <a href="/feedback"><?= t('Обратная связь') ?></a>
        </div>
    </div>
</div>
