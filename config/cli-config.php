<?php

use App\Component\Kernel\ServiceManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once __DIR__.'/bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = ServiceManager::i()->get(EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($entityManager);
