<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\web\View;

/**
 * @var Post $post
 * @var View $this
 */
BlogAsset::register($this);

$items = [];

echo Div::widget()
    ->class('container-xxl mt-5 px-4 px-xxl-2')
    ->content(
        Div::widget()
            ->class('d-lg-grid content')
            ->content(
                $this->render('../_sidebar'),
                $this->render('_post', ['post' => $post]),
            )
            ->id('content'),
    );
