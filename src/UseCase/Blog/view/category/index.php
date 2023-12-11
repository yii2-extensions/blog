<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\web\View;

/**
 * @var string $action
 * @var string $categoryTitle
 * @var Category $category
 * @var Post[] $posts
 * @var int $postCount
 * @var string $slug
 * @var View $this
 * @var string $xcard
 */
$items = [];

BlogAsset::register($this);

$this->title = Yii::t('yii.blog', 'Filter by Category: {category}', ['category' => $category->title]);

echo Div::widget()
    ->class('container-xxl mt-5 px-4 px-xxl-2')
    ->content(
        Div::widget()
            ->class('d-lg-grid content')
            ->content(
                $this->render(
                    '../_sidebar',
                    [
                        'action' => $action,
                        'categoryTitle' => $categoryTitle,
                        'postCount' => $postCount,
                        'slug' => $slug,
                    ],
                ),
                $this->render(
                    '_posts',
                    [
                        'category' => $category,
                        'posts' => $posts,
                    ],
                ),
            )
            ->id('content'),
    );
