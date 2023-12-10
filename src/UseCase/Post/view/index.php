<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\P;
use PHPForge\Html\Span;
use PHPForge\Html\Tag;
use sjaakp\icon\Icon;
use Yii2\Asset\BootboxAsset;
use Yii\Blog\Domain\Post\PostInterface;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\GridViewAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var View $this
 */
BootboxAsset::register($this);
GridViewAsset::register($this);

$this->title = Yii::t('yii.blog', 'Posts');

$columns = [
    [
        'attribute' => 'id',
        'label' => Yii::t('yii.blog', 'Id'),
        'headerOptions' => ['style' => 'width: 32px;'],
    ],
    [
        'attribute' => 'title',
        'format' => 'html',
        'label' => Yii::t('yii.blog', 'Title'),
        'headerOptions' => ['style' => 'min-width: 200px;'],
    ],
    [
        'attribute' => 'tags',
        'label' => Yii::t('yii.blog', 'tags'),
        'headerOptions' => ['style' => 'min-width: 50px;'],
        'format' => 'html',
        'value' => static function (PostInterface $model): string {
            $tags = '';

            foreach ($model->tags as $tag) {
                $tags .= Span::widget()->class('badge bg-primary me-2')->content($tag->name)->render();
            }

            return $tags;
        },
    ],
    [
        'attribute' => 'date',
        'label' => Yii::t('yii.blog', 'created_at'),
        'headerOptions' => ['style' => 'min-width: 50px;'],
        'value' => static fn (PostInterface $model): string => date('d.m.Y H:i', (int) $model->date),
    ],
    [
        'class' => ActionColumn::class,
        'contentOptions' => ['class' => 'text-nowrap text-center'],
        'header' => Yii::t('yii.blog', 'Actions'),
        'headerOptions' => ['class' => 'text-center'],
        'buttons' => [
            'delete' => static function (string $url, PostInterface $model): string {
                return A::widget()
                    ->class('border-0 fa-stack text-danger')
                    ->content(
                        Icon::renderIcon('solid', 'circle', ['class' => 'fa-stack-2x']),
                        Icon::renderIcon('solid', 'trash', ['class' => 'fa-stack-1x fa-inverse']),
                    )
                    ->dataAttributes(
                        [
                            'method' => 'POST',
                            'confirm' => Yii::t('yii.blog', 'Are you sure to delete this user?'),
                        ],
                    )
                    ->href(Url::to(['/category/delete', 'slug' => $model->slug]))
                    ->title(Yii::t('yii.blog', 'Delete'))
                    ->render();
            },
            'update' => static function (string $url, PostInterface $model): string {
                return A::widget()
                    ->class('border-0 fa-stack text-primary')
                    ->content(
                        Icon::renderIcon('solid', 'circle', ['class' => 'fa-stack-2x']),
                        Icon::renderIcon('solid', 'pen-to-square', ['class' => 'fa-stack-1x fa-inverse']),
                    )
                    ->href(Url::to(['/post/update', 'slug' => $model->slug]))
                    ->title(Yii::t('yii.blog', 'Update'))
                    ->render();
            },
        ],
        'template' => '{update} {delete}',
    ],
];
?>
<?= Div::widget()->class('container mt-3')->begin() ?>
    <?= Div::widget()->class('row align-items-center justify-content-center')->begin() ?>
        <?= Div::widget()->class('col-12')->begin() ?>
            <?=
                Div::widget()
                    ->class('bg-body-tertiary shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500')
                    ->content(
                        H::widget()->content(Encode::content($this->title))->class('fw-bold')->tagName('h1'),
                        P::widget()->content(Yii::t('yii.blog', 'Add, edit, delete, enable and disable categories.')),
                        Tag::widget()->class('mb-3')->tagName('hr'),
                        Div::widget()
                            ->class('d-flex justify-content-end mb-3')
                            ->content(
                                A::widget()
                                    ->class('btn btn-success')
                                    ->content(Icon::renderIcon('solid', 'plus'))
                                    ->href(Url::to(['/post/create']))
                                    ->title(Yii::t('yii.blog', 'Add post')),
                                ),
                        GridView::widget(
                            [
                                'id' => 'category-grid',
                                'columns' => $columns,
                                'dataProvider' => $dataProvider,
                                'layout' => "{items}\n{summary}\n{pager}",
                                'options' => ['class' => 'table-responsive'],
                                'pager' => [
                                    'activePageCssClass' => 'page-item active',
                                    'disabledListItemSubTagOptions' => [
                                        'tag' => 'a',
                                        'class' => 'page-link',
                                    ],
                                    'disabledPageCssClass' => 'page-item disabled',
                                    'linkOptions' => ['class' => 'page-link'],
                                    'options' => ['class' => 'pagination float-end ml-auto mb-5'],
                                ],
                                'tableOptions' => ['class' => 'table table-borderless'],
                            ],
                        ),
                    )
            ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Div::end();
