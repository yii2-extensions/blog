<?php

declare(strict_types=1);

use PHPForge\Component\Item;
use PHPForge\Component\Menu;
use PHPForge\Component\NavBar;
use yii\helpers\Url;

echo NavBar::widget()
    ->class('nav nav-pills justify-content-center flex-lg-column justify-content-lg-start gap-1 sidebar-nav')
    ->menu(
        Menu::widget()
            ->activeClass('active')
            ->container(false)
            ->currentPath(Yii::$app->request->url)
            ->items(
                Item::create()
                    ->label('All posts')
                    ->link(Url::to(['/blog/index']))
                    ->iconClass('fa-solid fa-newspaper me-2 d-flex align-items-center fw-600'),
                Item::create()
                    ->label('Archive')
                    ->link(Url::to(['/blog/archive']))
                    ->iconClass('fa-solid fa-box-archive me-2 d-flex align-items-center fw-600'),
                //Item::create()
                //    ->label('Subscribe')
                //    ->link(Url::to(['/blog/feed']))
                //    ->iconClass('fa-solid fa-rss me-2 d-flex align-items-center fw-600'),
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
