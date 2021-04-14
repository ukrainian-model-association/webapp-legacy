<?php

use App\Component\Kernel\ServiceManager;
use App\Entity\User;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;

ServiceManager::i()
    ->addProvider(
        EntityManagerInterface::class,
        static function () {
            $devMode = true;
            $cfg     = require __DIR__.'/config.php';

            $db           = $cfg['databases']['master'];
            $db['driver'] = 'pdo_pgsql';

            $memcache = new Memcache();
            $memcache->connect($cfg['mamcached']['host']);

            $cache = new MemcacheCache();
            $cache->setMemcache($memcache);

            $config = Setup::createAnnotationMetadataConfiguration(
                [
                    __DIR__.'/../src/Entity',
                ],
                $devMode,
                null,
                $cache,
                false
            );

            return EntityManager::create($db, $config);
        }
    );

// /** @var EntityManager $em */
// $em = ServiceManager::i()->get(EntityManagerInterface::class);
// $em->persist(
//     (new User())
//         ->setId(1)
//         ->setName('test')
// );
// $em->flush();
//
// $repo = $em->getRepository(User::class);
//
// var_dump($repo->findAll());
//
// // var_dump(ServiceManager::i()->get(EntityManagerInterface::class));
// die;