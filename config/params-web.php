<?php

declare(strict_types=1);

use Yii\Blog\UseCase\Blog\BlogController;
use Yii\Blog\UseCase\Category\CategoryController;
use Yii\Blog\UseCase\Post\PostController;
use Yii\Blog\UseCase\Tag\TagController;

return [
    'app.controllerMap' => [
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
    'app.params' => [
        'app.menu.islogged' => [
            [
                'label' => 'Category',
                'url' => ['/category/index'],
                'order' => 1,
                'category' => 'yii.blog',
            ],
            [
                'label' => 'Post',
                'url' => ['/post/index'],
                'order' => 1,
                'category' => 'yii.blog',
            ],
        ],
        'icons' => '@npm/fortawesome--fontawesome-free/svgs/{family}/{name}.svg',
    ],
];
