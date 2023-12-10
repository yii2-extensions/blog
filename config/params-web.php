<?php

declare(strict_types=1);

use Yii\Blog\UseCase\Blog\BlogController;
use Yii\Blog\UseCase\Category\CategoryController;
use Yii\Blog\UseCase\Post\PostController;
use Yii\Blog\UseCase\Tag\TagController;

return [
    'web.controllerMap' => [
        'category' => [
            'class' => CategoryController::class,
        ],
        'blog' => [
            'class' => BlogController::class,
        ],
        'post' => [
            'class' => PostController::class,
        ],
        'tag' => [
            'class' => TagController::class,
        ],
    ],
    'web.params' => [
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
