<?php

define('APP_START_TS', microtime(true));

require_once sprintf('%s/library/kernel/load.php', getenv('FRAMEWORK_PATH'));

load::system('kernel/conf');
$config = require sprintf('%s/config/%s.php', __DIR__, getenv('ENVIRONMENT'));

require_once './apps/imgserve/index.php';

$imgserve = new imgserve($config);
$imgserve->execute();
