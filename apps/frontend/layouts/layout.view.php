<?php

/**
 * @var $controller frontend_controller
 */

use App\Component\Asset\Asset;
use App\Component\Asset\AssetFactory;
use App\Component\Asset\AssetManager;
use App\Component\Asset\AssetTypes;
use App\Component\ServiceContainer;

/** @var ServiceContainer $di */
$di = require __DIR__.'/_services.php';
/** @var AssetFactory $assets */
$assets       = $di->get(AssetFactory::class);
$assetManager = $di->get(AssetManager::class);

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= client_helper::get_meta() ?>

    <title><?= client_helper::get_title() ?></title>

    <?= $assets->script('/public/js/api.js"') ?>
    <?= $assets->script('/public/js/jquery-1.7.2.min.js"') ?>
    <?= $assets->script('/public/js/jquery/jquery-ui-1.8.13.custom.min.js"') ?>
    <?= $assets->script('/main.js') ?>
    <?= $assets->script('/erlte.js') ?>
    <?= $assets->script('https://kit.fontawesome.com/7edf9be78e.js') ?>
    <?= $assets->stylesheet('/public/css/flag-icon.min.css') ?>
    <?= $assets->stylesheet('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.css') ?>
    <?= $assets->stylesheet('https://fonts.googleapis.com/icon?family=Material+Icons') ?>
    <?= $assets->stylesheet('/main.css') ?>
    <?= $assets->stylesheet('/erlte.css') ?>

    <?php include __DIR__.'/partials/contextjs.php' ?>

    <?= $assets->stylesheet('https://fonts.googleapis.com/css2?family=Russo+One&display=swap') ?>

    <link rel="apple-touch-icon" sizes="57x57" href="/public/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/public/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/public/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/public/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/public/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/public/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/public/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/public/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/public/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/public/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/favicon/favicon-16x16.png">
    <link rel="manifest" href="/public/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/public/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<div class="container">
    <div class="grid-container">
        <div></div>
        <div>
            <?php include __DIR__.'/partials/logo.php' ?>
            <?php include __DIR__.'/partials/menu.php' ?>
            <div>
                <div class="content">
                    <?php include $controller->get_template_path(); ?>
                </div>
            </div>
        </div>
        <div></div>
    </div>
</div>
<?php include __DIR__.'/partials/footer.php' ?>
<?php //include __DIR__.'/partials/captcha.php' ?>

<script>const jQuery = $.noConflict(true);</script>
<?= $assets->script('https://code.jquery.com/jquery-3.5.1.min.js', ['crossorigin' => 'anonymous']) ?>
<?= $assets->script('https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js') ?>
<?= $assets->script('https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.js') ?>
<?= $assets->script('/public/js/app.js') ?>
<?= $assetManager
        ->findByType(AssetTypes::JAVASCRIPT)
        ->map(
                static function (Asset $asset) use ($assets) {
                    return $assets->script($asset->getUrl());
                }
        )
?>
</body>
</html>
