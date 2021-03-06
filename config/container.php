<?php

use App\Entity\User;

require $app->getConfigurationDir().'/security.php';

$app['assets.version'] = 'v1';

$app['db.options'] = [
    'driver'   => $_SERVER['APP_DATABASE_DRIVER'],
    'host'     => $_SERVER['APP_DATABASE_HOST'],
    'user'     => $_SERVER['APP_DATABASE_USER'],
    'password' => $_SERVER['APP_DATABASE_PASSWORD'],
    'dbname'   => $_SERVER['APP_DATABASE_NAME']
];

$app['monolog.logfile'] = $app->getLogDir().'/'.$app->getEnvironment().'.log';

// https://github.com/dflydev/dflydev-doctrine-orm-service-provider
$app['orm.proxies_dir'] = $app->getCacheDir().'/doctrine/orm/proxies';
$app['orm.em.options'] = [
    'mappings' => [
        [
            'type'      => 'annotation',
            'namespace' => 'App\Entity',
            'path'      => $app->getRootDir().'/src/Entity',
            'use_simple_annotation_reader' => false
        ]
    ]
];

// https://github.com/awurth/SilexUserBundle
$app['silex_user.options'] = [
    'object_manager' => 'orm.em',
    'user_class'     => User::class,
    'firewall_name'  => 'main',
    'use_templates'  => false,
    'use_authentication_listener'          => false,
    'registration.confirmation.enabled'    => false,
    'registration.confirmation.from_email' => $_SERVER['APP_MAILER_USER']
];

$app['swiftmailer.options'] = [
    'host'       => $_SERVER['APP_MAILER_HOST'],
    'port'       => $_SERVER['APP_MAILER_PORT'],
    'username'   => $_SERVER['APP_MAILER_USER'],
    'password'   => $_SERVER['APP_MAILER_PASSWORD'],
    'encryption' => $_SERVER['APP_MAILER_ENCRYPTION'],
    'auth_mode'  => $_SERVER['APP_MAILER_AUTH_MODE']
];

$app['translator.cache_dir'] = $app->getCacheDir().'/translations';

$app['twig.options'] = [
    'cache' => $app->getCacheDir().'/twig'
];

$app['twig.path'] = [
    $app->getRootDir().'/templates'
];
