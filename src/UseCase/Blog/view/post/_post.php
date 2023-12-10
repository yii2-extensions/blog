<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\Img;
use PHPForge\Html\Span;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Helper\CardXGenerator;
use yii\web\View;

/**
 * @var Post $post
 * @var View $this
 */
?>
<?= Div::widget()->class('single-post')->begin() ?>
    <?php $this->title = Encode::content(Yii::t('yii.blog', $post->title)); ?>
    <?php CardXGenerator::generate((string) $post->id, $post->title) ?>
    <?=
        Div::widget()
            ->class('post-header mb-5 text-center')
            ->content(
                H::widget()->class('post-title mt-2')->content($post->title)->tagName('h2'),
                Div::widget()
                    ->class('fw-bold post-meta')
                    ->content(
                        Span::widget()
                            ->class('text-uppercase font-sm letter-spacing-1')
                            ->content(
                                Yii::$app->formatter->asDate($post->date, 'medium'),
                            ),
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
