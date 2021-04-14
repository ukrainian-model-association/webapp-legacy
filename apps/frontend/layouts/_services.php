<?php

use App\Component\Asset\AssetFactory;
use App\Component\Asset\AssetManager;
use App\Component\ServiceContainer;
use App\Component\UI\UIBuilder;
use App\Service\TwigBuilder;
use Twig\Environment as Twig;

$di = new ServiceContainer();
$di->register(
    'ui',
    UIBuilder::create()
        ->addPath(sprintf('%s/templates', conf::get('project_root')))
        ->build()
);


$assets = AssetFactory::create();
$twig   = (new TwigBuilder())->build();
$di
    ->register(AssetManager::class, AssetManager::create())
    ->register(AssetFactory::class, AssetFactory::create())
    ->register(Twig::class, $twig);

return $di;
