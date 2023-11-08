<?php

declare(strict_types=1);

use Yii\Blog\UseCase\Category\CategoryController;

return [
    'app.aliases' => [
        '@yii-blog' => '@vendor/yii2-extensions/blog',
        '@yii-blog/migration' => '@yii-blog/src/Framework/Migration',
    ],
    'app.controllerMap' => [
        'category' => [
            'class' => CategoryController::class,
        ],
    ],
    'app.params' => [
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
