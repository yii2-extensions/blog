<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use PHPForge\Html\Helper\Encode;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Framework\Asset\BlogAsset;
use Yii\Blog\Helper\CardXGenerator;
use yii\web\View;

/**
 * @var string $action
 * @var string $categoryTitle
 * @var Post $post
 * @var int $postCount
 * @var string $slug
 * @var View $this
 * @var string $xcard
 */
$items = [];

BlogAsset::register($this);
CardXGenerator::generate((string) $post->id, $post->title);

$this->title = Encode::content($post->title);
$this->params['keywords'] = $post->seo->keywords;
$this->params['description'] = $post->seo->description;
$this->params['slug'] = $slug;
$this->params['xcard'] = $xcard;

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
                    '_post',
                    [
                        'post' => $post,
                    ],
                ),
            )
            ->id('content'),
    );
