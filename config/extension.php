<?php

declare(strict_types=1);

use Yii\Blog\Framework\EventHandler\CategoryRegisterEventHandler;
use yii\i18n\PhpMessageSource;

return [
    'bootstrap' => [
        CategoryRegisterEventHandler::class,
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'yii.blog' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@resource/message',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'category/delete/<slug>' => 'category/delete',
                'category/disable/<slug>' => 'category/disable',
                'category/enable/<slug>' => 'category/enable',
                'category/index/<slug>' => 'category/index',
                'category/index/page/<page>/per-page/<per-page>' => 'category/index',
                'category/update/<slug>' => 'category/update',
            ],
        ],
    ],
];
