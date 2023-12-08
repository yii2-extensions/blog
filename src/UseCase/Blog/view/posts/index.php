<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use Yii2\Asset\Css\FontAwesomeAsset;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var ActiveDataProvider $posts
 * @var View $this
 */
BlogAsset::register($this);
FontAwesomeAsset::register($this);

$items = [];

echo Div::widget()
    ->class('container-xxl mt-5 px-4 px-xxl-2')
    ->content(
        Div::widget()
            ->class('d-lg-grid content')
            ->content(
                $this->render('../_sidebar'),
                $this->render('_posts', ['posts' => $posts]),
            )
            ->id('content'),
        Div::widget()
            ->class('d-flex justify-content-end')
            ->content(
                LinkPager::widget(
                    [
                        'pagination' => $posts->getPagination(),
                        'options' => ['class' => 'pagination mt-4'],
                    ]
                )
            ),
    );

