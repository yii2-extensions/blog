<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Img;
use PHPForge\Html\Span;
use Yii\Blog\Domain\Post\Post;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var Post $post
 * @var View $this
 */
?>
<?= Div::widget()->class('single-post')->begin() ?>
    <?=
        Div::widget()
            ->class('post-header mb-5 text-center')
            ->content(
                H::widget()->class('post-title mt-2')->content($post->title)->tagName('h1'),
                Div::widget()
                    ->class('d-flex justify-content-between')
                    ->content(
                        Span::widget()
                            ->class('text-muted letter-spacing text-uppercase font-sm')
                            ->content(Yii::$app->formatter->asDate($post->date, 'medium')),
                        A::widget()
                            ->class('btn bs-orange-bg btn-sm justify-content start font-weight-bold text-white')
                            ->content($post->category->title)
                            ->href(Url::to(['blog/category', 'slug' => $post->category->slug]))
                    ),
                Div::widget()
                    ->class('post-featured-image mt-5')
                    ->content(
                        Img::widget()
                            ->alt('featured-image')
                            ->class('img-fluid w-100')
                            ->src("/uploads/$post->image_file")
                    )
            )
    ?>
    <?=
        Div::widget()
            ->class('post-body')
            ->content(
                Div::widget()->class('entry-content')->content($post->content),
                Div::widget()
                    ->class('post-tags mb-5')
                    ->content(
                        implode(
                            ' ',
                            array_map(
                                static fn ($tag): string => A::widget()
                                    ->href('#')
                                    ->content($tag->name)
                                    ->render(),
                                $post->tags,
                            )
                        )
                    )
            )
    ?>
<?= Div::end();
