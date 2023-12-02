<?php

declare(strict_types=1);

use Yii\User\Framework\EventHandler\RegisterEventHandler;
use yii\web\Session;

/**
 * @var array $params
 */
return [
    'aliases' => [
        '@app' => dirname(__DIR__, 3),
        '@bower' => '@app/node_modules',
        '@npm' => '@app/node_modules',
        '@resource' => '@app/tests/Support/Data/Framework/resource',
        '@runtime' => '@app/tests/Support/Data/public/runtime',
        '@web' => '@app/tests/Support/Data/public',
        '@webroot/assets' => '@web/assets',
        '@yii-blog/migration' => '@app/src/Framework/Migration',
    ],
    'basePath' => dirname(__DIR__, 3),
    'container' => [
        'singletons' => [
            Session::class => static function (): Session {
                return new Session();
            },
        ],
    ],
    'controllerMap' => $params['app.controllerMap'],
    'id' => 'app-tests',
    'language' => 'en-US',
    'name' => 'Web application basic',
    'on beforeAction' => static function (): void {
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    },
    'params' => $params['app.params'] ?? [],
    'runtimePath' => dirname(__DIR__, 3) . '/tests/Support/Data/public/runtime',
];
