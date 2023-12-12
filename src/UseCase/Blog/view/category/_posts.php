<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Img;
use PHPForge\Html\Span;
use PHPForge\Html\Tag;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var Category $category
 * @var Post[] $posts
 * @var View $this
 */
BlogAsset::register($this);

$items = [];
?>
<?= Div::widget()->class('media mt-5')->begin() ?>
    <?=
        Div::widget()
            ->class('d-flex justify-content-end mb-3')
            ->content(
                A::widget()
                    ->class('btn bs-orange-bg btn-sm justify-content start font-weight-bold text-white')
                    ->content($category->title)
                    ->href(Url::to(['blog/category', 'slug' => $category->slug]))
            )
    ?>
    <?php foreach ($posts as $post): ?>
        <?=
            Div::widget()
                ->class('media-body')
                ->content(
                    A::widget()
                        ->content(
                            H::widget()
                                ->class('fs-4 font-weight-bold mb-3 text-justify')
                                ->content($post->title)
                                ->tagName('h1')
                        )
                        ->href(Url::to(['blog/post', 'slug' => $post->slug])),
                    Div::widget()
                        ->class('d-flex justify-content-between')
                        ->content(
                            Span::widget()
                                ->class('text-muted letter-spacing text-uppercase font-sm')
                                ->content(Yii::$app->formatter->asDate($post->date, 'medium')),
                        ),
                    Img::widget()
                        ->alt($post->title)
                        ->class('img-fluid mt-3 mb-3')
                        ->src("/uploads/$post->image_file")
                        ->height('100px'),
                    H::widget()
                        ->class('font-xs mt-3 mb-3')
                        ->content($post->content_short)
                        ->tagName('h5'),
                    A::widget()
                        ->class('btn btn-primary btn-sm justify-content start text-white')
                        ->content(
                            Yii::t('yii.blog', 'Read more')
                        )
                        ->href(Url::to(['blog/post', 'slug' => $post->slug])),
                    Div::widget()
                        ->class('d-flex mt-4')
                        ->content(
                            Span::widget()
                                ->class('text-muted')
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
                        ),
                    Tag::widget()->class('mb-4')->tagName('hr'),
                )
        ?>
    <?php endforeach; ?>
<?= Div::end();
