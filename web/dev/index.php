<?php

use Silex\Application;
use Symfony\Component\Debug\Debug;

require __DIR__ . '/../../vendor/autoload.php';

Debug::enable();

$app = new Application();

$app['debug'] = true;

require __DIR__ . '/../../app/providers_dev.php';

require __DIR__ . '/../../app/controllers.php';

require __DIR__ . '/../../app/routing.php';

$app->run();