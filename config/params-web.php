<?php

declare(strict_types=1);

use Yii\Blog\UseCase\Category\CategoryController;

return [
    'app.controllerMap' => [
        'category' => [
            'class' => CategoryController::class,
        ],
    ],
    'app.menu.islogged' => [
        [
            'label' => 'Category',
            'url' => ['/category/index'],
            'order' => 1,
            'category' => 'yii.user',
            'linkOptions' => [
                'data-method' => 'post',
            ],
        ],
    ],
    'app.params' => [
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
