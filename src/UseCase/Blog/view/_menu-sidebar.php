<?php

declare(strict_types=1);

use PHPForge\Component\Item;
use PHPForge\Component\Menu;
use PHPForge\Component\NavBar;
use Yii2\Asset\Cdn\FontAwesomeAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */
FontAwesomeAsset::register($this);

echo NavBar::widget()
    ->class('nav nav-pills justify-content-center flex-lg-column justify-content-lg-start gap-1 sidebar-nav')
    ->menu(
        Menu::widget()
            ->activeClass('active')
            ->container(false)
            ->currentPath(Yii::$app->request->url)
            ->items(
                Item::create()
                    ->label(Yii::t('yii.blog', 'All posts'))
                    ->link(Url::to(['/blog/index']))
                    ->iconClass('fa-solid fa-newspaper fa-lg me-2 d-flex align-items-center fw-600'),
                Item::create()
                    ->label(Yii::t('yii.blog', 'Follow me'))
                    ->link('https://twitter.com/Terabytesoftw')
                    ->linkAttributes(['target' => 'blank'])
                    ->iconClass('fa-brands fa-x-twitter fa-lg me-2 d-flex align-items-center fw-600'),
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
