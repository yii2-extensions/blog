<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use PHPForge\Html\Helper\Encode;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Framework\Asset\BlogAsset;
use Yii\Blog\Helper\CardXGenerator;
use yii\web\View;

/**
 * @var Post $post
 * @var View $this
 * @var string $xcard
 */
$items = [];

BlogAsset::register($this);
CardXGenerator::generate((string) $post->id, $post->title);

$this->title = Encode::content($post->slug);
$this->params['xcard'] = $xcard;

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
