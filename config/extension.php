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
                ],
            ],
        ],
    ],
];
