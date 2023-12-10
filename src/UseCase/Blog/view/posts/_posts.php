<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Img;
use PHPForge\Html\Span;
use PHPForge\Html\Tag;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var ActiveDataProvider $posts
 * @var View $this
 */
BlogAsset::register($this);

$items = [];
?>

<?= Div::widget()->class('media mt-5')->begin() ?>
    <?php foreach ($posts->getModels() as $post): ?>
        <?=
            Div::widget()
                ->class('media-body')
                ->content(
                    A::widget()
                        ->content(
                            H::widget()
                                ->class('font-weight-bold mb-3')
                                ->content($post->title)
                                ->tagName('h4')
                        )
                        ->href(Url::to(['blog/post', 'slug' => $post->slug])),
                    Span::widget()
                        ->class('text-muted letter-spacing text-uppercase font-sm')
                        ->content(Yii::$app->formatter->asDate($post->date, 'medium')),
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
                        ->class('btn btn-primary btn-sm text-white')
                        ->content(
                            Yii::t('yii.blog', 'Read more')
                        )
                        ->href(Url::to(['blog/post', 'slug' => $post->slug])),
                    Tag::widget()->class('mb-4')->tagName('hr'),
                )
        ?>
    <?php endforeach; ?>
<?= Div::end();
