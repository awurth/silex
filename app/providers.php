<?php

use Symfony\Component\Yaml\Yaml;

use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\CsrfServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;
use Saxulum\DoctrineOrmManagerRegistry\Provider\DoctrineOrmManagerRegistryProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\AssetServiceProvider;

const ROOT_DIR = __DIR__ . '/../';

$parameters = Yaml::parse(file_get_contents(__DIR__ . '/parameters.yml'))['parameters'];

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => ROOT_DIR . 'var/logs/dev.log'
]);

$app->register(new ServiceControllerServiceProvider());

$app->register(new SessionServiceProvider());

$app->register(new ValidatorServiceProvider());

$app->register(new FormServiceProvider());

$app->register(new CsrfServiceProvider());

$app->register(new LocaleServiceProvider());

$app->register(new TranslationServiceProvider());

$app->register(new DoctrineServiceProvider(), [
    'db.options' => $parameters
]);

$app->register(new DoctrineOrmServiceProvider(), [
    'orm.em.options' => [
        'mappings' => [
            [
                'type' => 'annotation',
                'namespace' => 'App\Entity',
                'path' => ROOT_DIR . 'src/App/Entity',
                'use_simple_annotation_reader' => false
            ]
        ]
    ]
]);

$app->register(new DoctrineOrmManagerRegistryProvider());

$app->register(new HttpFragmentServiceProvider());

$app->register(new SecurityServiceProvider(), [
    'security.role_hierarchy' => [
        'ROLE_ADMIN' => [
            'ROLE_USER',
            'ROLE_ALLOWED_TO_SWITCH'
        ]
    ],
    'security.firewalls' => [
        'login' => [
            'pattern' => '^/login$'
        ],
        'secured' => [
            'pattern' => '^/',
            'form' => [
                'login_path' => '/login',
                'check_path' => '/login_check'
            ],
            'logout' => [
                'logout_path' => '/logout',
                'invalidate_session' => true
            ],
            'anonymous' => true
        ]
    ]
]);

$app->register(new TwigServiceProvider(), [
    'twig.path' => ROOT_DIR . 'src/App/Resources/views',
    'twig.options' => [
        'cache' => ROOT_DIR . 'var/cache/twig',
        'debug' => true,
        'auto_reload' => true
    ]
]);

$app->register(new AssetServiceProvider(), [
    'assets.version' => 'v1'
]);