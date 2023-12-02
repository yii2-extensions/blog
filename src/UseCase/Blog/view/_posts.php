<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Img;
use PHPForge\Html\Span;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\web\View;

/**
 * @var ActiveDataProvider $posts
 * @var View $this
 */
?>

<?= Div::widget()->class('col-lg-8 col-md-12 col-sm-12 col-xs-12')->begin() ?>
    <?php foreach ($posts->getModels() as $post): ?>
        <?=
            Div::widget()
                ->class('single-post')
                ->content(
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
                        ),
                    Div::widget()
                        ->class('post-body')
                        ->content(
                            Div::widget()->class('entry-content')->content($post->content),
                            Div::widget()
                                ->class('post-tags')
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
                )
        ?>
    <?php endforeach; ?>
    <?=
        Div::widget()
            ->class('float-end')
            ->content(
                LinkPager::widget(
                    [
                        'pagination' => $posts->getPagination(),
                        'options' => ['class' => 'pagination justify-content-center mt-4'],
                    ]
                )
            )
    ?>
<?= Div::end();
