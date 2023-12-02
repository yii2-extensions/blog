<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\I;
use PHPForge\Html\Img;
use PHPForge\Html\Li;
use PHPForge\Html\P;
use PHPForge\Html\Section;
use PHPForge\Html\Span;
use PHPForge\Html\Ul;
use Yii2\Asset\Css\FontAwesomeAsset;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\View;

/**
 * @var ActiveRecord[] $categories
 * @var ActiveDataProvider $posts
 * @var ActiveRecord[] $trendings
 * @var View $this
 */
FontAwesomeAsset::register($this);

$items = [];
?>

<?= Section::widget()->class('single-block-wrapper section-padding mt-5')->begin() ?>
    <?= Div::widget()->class('container')->begin() ?>
        <?= Div::widget()->class('row')->begin() ?>
            <?= Div::widget()->class('col-lg-4 col-md-4 col-sm-12 col-xs-12')->begin() ?>
                <?= Div::widget()->class('sidebar sidebar-right')->begin() ?>
                    <?= Div::widget()->class('sidebar-wrap mt-5 mt-lg-0')->begin() ?>
                        <?=
                            Div::widget()
                                ->class('sidebar-widget about mb-5 text-center p-3')
                                ->content(
                                    Div::widget()
                                        ->class('about-author')
                                        ->content(
                                            Img::widget()
                                                ->src('/image/profile.jpg')
                                                ->alt('Wilmer Arambula')
                                                ->class('img-fluid')
                                                ->render()
                                        ),
                                    H::widget()
                                        ->class('mb-0 mt-4')
                                        ->content(Yii::t('yii.blog', 'Wilmer Arambula'))
                                        ->tagName('h4'),
                                    P::widget()
                                        ->content(Yii::t('yii.blog', 'Developer Blogger'))
                                        ->render(),
                                    P::widget()
                                        ->content(
                                            'Hi, I’m Wilmer Arambula, a developer blogger.',
                                            "<br/>",
                                            'I love to write about Programming & Technology.',
                                            "<br/>",
                                            'I’m passionate about it since 1995.',
                                        )
                                        ->render(),
                                )
                        ?>
                        <?=
                            Div::widget()
                                ->class('sidebar-widget follow mb-5 text-center')
                                ->content(
                                    H::widget()
                                        ->class('text-center widget-title')
                                        ->content('Follow Me')
                                        ->tagName('h4'),
                                    Div::widget()
                                        ->class('follow-socials')
                                        ->content(
                                            A::widget()
                                                ->content(I::widget()->class('fa-brands fa-github fa-2x'))
                                                ->href('#'),
                                            A::widget()
                                                ->content(I::widget()->class('fa-brands fa-twitter fa-2x'))
                                                ->href('#'),
                                        )
                                )
                        ?>
                        <?= Div::widget()->class('sidebar-widget mb-5')->begin() ?>
                            <?=
                                H::widget()
                                    ->class('text-center widget-title')
                                    ->content('Trending Posts')
                                    ->tagName('h4')
                            ?>
                            <?php foreach ($trendings as $trending): ?>
                                <?=
                                    Div::widget()
                                        ->class('media border-bottom py-3 sidebar-post-item')
                                        ->content(
                                            Div::widget()
                                                ->class('media-body')
                                                ->content(
                                                    Span::widget()
                                                        ->class('text-muted letter-spacing text-uppercase font-sm')
                                                        ->content(Yii::$app->formatter->asDate($trending->date, 'medium')),
                                                    H::widget()
                                                        ->class('text-dark font-weight-bold')
                                                        ->content($trending->title)
                                                        ->tagName('h4'),
                                                    H::widget()
                                                        ->class('text-muted font-xs')
                                                        ->content($trending->content_short)
                                                        ->tagName('h5'),
                                                )
                                        )
                                ?>
                            <?php endforeach; ?>
                        <?= Div::end() ?>
                        <?= Div::widget()->class('sidebar-widget category mb-5')->begin() ?>
                            <?= H::widget()->class('text-center widget-title')->content('Categories')->tagName('h4') ?>
                            <?php foreach ($categories as $category): ?>
                                <?php $count = 0 ?>
                                <?php foreach ($category->post as $post): ?>
                                    <?php $count++ ?>
                                <?php endforeach; ?>
                                <?php if ($count > 0): ?>
                                    <?php
                                        $items[] = Li::widget()
                                            ->class('align-items-center d-flex justify-content-between')
                                            ->content(
                                                A::widget()->href('#')->content($category->title)->render(),
                                                Span::widget()->content((string) $count)->render(),
                                            )
                                    ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?= Ul::widget()->class('list-unstyled')->content(...$items) ?>
                        <?= Div::end() ?>
                    <?= Div::end() ?>
				<?= Div::end() ?>
            <?= Div::end() ?>
            <?= $this->render('_posts', ['posts' => $posts]) ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Section::end() ?>
