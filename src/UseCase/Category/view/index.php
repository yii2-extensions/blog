<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\I;
use PHPForge\Html\P;
use PHPForge\Html\Span;
use PHPForge\Html\Tag;
use sjaakp\icon\Icon;
use Yii2\Asset\BootboxAsset;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\GridViewAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var View $this
 */
BootboxAsset::register($this);
GridViewAsset::register($this);

$this->title = Yii::t('yii.blog', 'Categories');

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
        'value' => static function ($model) {
            $value = '';

            if (\count($model->children)) {
                $value = I::widget()->class('caret');
            }

            return $value .= match($model->depth > 0) {
                true => Span::widget()
                    ->class($model->status === '0' ? 'text-decoration-line-through' : 'text-primary')
                    ->content($model->title),
                default => Span::widget()
                    ->class($model->status === '0' ? 'text-decoration-line-through' : '')
                    ->content($model->title),
            };
        },
        'contentOptions' => function ($model) {
            return $model->depth > 0
                ? ['class' => 'text-nowrap ps-4']
                : ['class' => 'text-nowrap'];
        },
    ],
    [
        'attribute' => 'description',
        'contentOptions' => static fn(stdClass $model) => $model->status === '0'
            ? ['class' => 'text-decoration-line-through', 'style' => 'text-align: justify;']
            : ['style' => 'text-align: justify;'],
        'label' => Yii::t('yii.blog', 'Description'),
        'headerOptions' => ['style' => 'min-width: 640px;width: 640px;'],
    ],
    [
        'class' => ActionColumn::class,
        'contentOptions' => ['class' => 'text-nowrap text-center'],
        'header' => Yii::t('yii.blog', 'Actions'),
        'headerOptions' => ['class' => 'text-center'],
        'buttons' => [
            'delete' => function (string $url, stdClass $model) {
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
            'status' => static function (string $url, stdClass $model): string {
                return match ($model->status) {
                    '1' => A::widget()
                        ->class('border-0 fa-stack text-danger-emphasis')
                        ->content(
                            Icon::renderIcon('solid', 'circle', ['class' => 'fa-stack-2x']),
                            Icon::renderIcon('solid', 'eye-slash', ['class' => 'fa-stack-1x fa-inverse']),
                        )
                        ->dataAttributes(
                            [
                                'method' => 'POST',
                                'confirm' => Yii::t('yii.blog', 'Are you sure to disable this category?'),
                            ],
                        )
                        ->href(Url::to(['/category/disable', 'slug' => $model->slug]))
                        ->title(Yii::t('yii.blog', 'Disable category'))
                        ->render(),
                    default => A::widget()
                        ->class('border-0 fa-stack text-info-emphasis')
                        ->content(
                            Icon::renderIcon('solid', 'circle', ['class' => 'fa-stack-2x']),
                            Icon::renderIcon('solid', 'eye', ['class' => 'fa-stack-1x fa-inverse']),
                        )
                        ->dataAttributes(
                            [
                                'method' => 'POST',
                                'confirm' => Yii::t('yii.blog', 'Are you sure to enable this category?'),
                            ],
                        )
                        ->href(Url::to(['/category/enable', 'slug' => $model->slug]))
                        ->title(Yii::t('yii.blog', 'Enable category'))
                        ->render(),
                };
            },
            'update' => static function (string $url, stdClass $model) {
                return A::widget()
                    ->class('border-0 fa-stack text-primary')
                    ->content(
                        Icon::renderIcon('solid', 'circle', ['class' => 'fa-stack-2x']),
                        Icon::renderIcon('solid', 'pen-to-square', ['class' => 'fa-stack-1x fa-inverse']),
                    )
                    ->href(Url::to(['/category/update', 'slug' => $model->slug]))
                    ->title(Yii::t('yii.blog', 'Update'))
                    ->render();
            },
        ],
        'template' => '{update} {delete} {status}',
    ],
    [
        'class' => ActionColumn::class,
        'contentOptions' => ['class' => 'text-center'],
        'header' => Yii::t('yii.blog', 'Subcategory'),
        'headerOptions' => ['class' => 'text-center'],
        'buttons' => [
            'register' => function (string $url, stdClass $model) {
                return match ($model->depth) {
                    '0' => A::widget()
                        ->class('border-0 fa-stack text-success')
                        ->content(
                            Icon::renderIcon('solid', 'circle', ['class' => 'fa-stack-2x']),
                            Icon::renderIcon('solid', 'plus', ['class' => 'fa-stack-1x fa-inverse']),
                        )
                        ->href($url)
                        ->title(Yii::t('yii.blog', 'Add subcategory'))
                        ->render(),
                    default => '',
                };
            },
        ],
        'template' => '{register}',
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
                                    ->href(Url::to(['/category/register']))
                                    ->title(Yii::t('yii.blog', 'Add category')),
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
                                'rowOptions' => function ($model) {
                                    return $model->depth == 0 ? ['class' => 'fw-bold'] : [];
                                },
                                'tableOptions' => ['class' => 'table table-borderless'],
                            ],
                        ),
                    )
            ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Div::end();
