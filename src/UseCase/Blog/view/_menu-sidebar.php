<?php

declare(strict_types=1);

use PHPForge\Component\Item;
use PHPForge\Component\Menu;
use PHPForge\Component\NavBar;
use sjaakp\icon\Icon;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var string $action
 * @var string $categoryTitle
 * @var int $postCount
 * @var string $slug
 * @var View $this
 */
$labelLatest = match ($action) {
    'category', 'post' => Yii::t('yii.blog', 'Latest'),
    default => Yii::t('yii.blog', 'Latest ({post.count})', ['post.count' => $postCount]),
};

echo NavBar::widget()
    ->class('nav nav-pills justify-content-center flex-lg-column justify-content-lg-start gap-1 sidebar-nav')
    ->menu(
        Menu::widget()
            ->activeClass('active')
            ->container(false)
            ->currentPath(Yii::$app->request->url)
            ->items(
                Item::create()
                    ->label($labelLatest)
                    ->link(Url::to(['/blog/index']))
                    ->iconContainerClass('d-flex align-items-center fa-xl fw-600')
                    ->iconText(
                        Icon::renderIcon('solid', 'fire', ['class' => 'me-2']),
                    ),
                Item::create()
                    ->label(Yii::t('yii.blog', 'Follow me'))
                    ->link('https://twitter.com/Terabytesoftw')
                    ->linkAttributes(['target' => 'blank'])
                    ->iconContainerClass('d-flex align-items-center fa-xl fw-600')
                    ->iconText(
                        Icon::renderIcon('brands', 'x-twitter', ['class' => 'me-2']),
                    ),
                Item::create()
                    ->label(
                        Yii::t(
                            'yii.blog',
                            'By Category: {category} ({post.count})',
                            ['category' => $categoryTitle, 'post.count' => $postCount],
                        )
                    )
                    ->link(Url::to(['/blog/category', 'slug' => $slug]))
                    ->iconContainerClass('d-flex align-items-center fa-xl fw-600')
                    ->iconText(
                        Icon::renderIcon('solid', 'filter', ['class' => 'me-2']),
                    )
                    ->active($action === 'category')
                    ->visible($action === 'category'),
                Item::create()
                    ->label(Yii::t('yii.blog', 'By Post'))
                    ->link(Url::to(['/blog/post', 'slug' => $slug]))
                    ->iconContainerClass('d-flex align-items-center fa-xl fw-600')
                    ->iconText(
                        Icon::renderIcon('solid', 'filter', ['class' => 'me-2']),
                    )
                    ->active($action === 'post')
                    ->visible($action === 'post')
            )
            ->id('w0-collapse')
            ->linkClass('nav-link d-flex align-items-center fw-600')
            ->listClass('navbar-nav mb-2 mb-lg-0')
            ->listItemTag(false)
            ->listType(false)
            ->toggle(false)
    )
    ->containerMenu(false)
    ->render();
