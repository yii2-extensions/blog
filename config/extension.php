<?php

declare(strict_types=1);

use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Category\CategoryInterface;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Domain\Post\PostInterface;
use Yii\Blog\Domain\Seo\Seo;
use Yii\Blog\Domain\Seo\SeoInterface;
use Yii\Blog\Domain\Tag\Tag;
use Yii\Blog\Domain\Tag\TagInterface;
use Yii\Blog\Domain\Tag\TagItem;
use Yii\Blog\Domain\Tag\TagItemInterface;
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
                    'basePath' => '@yii-blog/src/Framework/resource/message',
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
                'post/create' => 'post/create',
                'post/index/page/<page>/per-page/<per-page>' => 'post/index',
            ],
        ],
    ],
    'container' => [
        'definitions' => [
            CategoryInterface::class => Category::class,
            PostInterface::class => Post::class,
            SeoInterface::class => Seo::class,
            TagInterface::class => Tag::class,
            TagItemInterface::class => TagItem::class,
        ],
    ]
];
