<?php

declare(strict_types=1);

use PHPForge\Html\Button;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\P;
use PHPForge\Html\Tag;
use sjaakp\icon\Icon;
use Yii2\Asset\Cdn\FontAwesomeAsset;
use Yii2\Extensions\DateTimePicker\DateTimePicker;
use Yii2\Extensions\FilePond\FilePond;
use Yii2\Extensions\Selectize\Selectize;
use Yii2\Extensions\Summernote\Summernote;
use Yii\Blog\BlogModule;
use Yii\Blog\UseCase\Post\PostForm;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\Blog\UseCase\Seo\SeoWidget;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * @var BlogModule $blogModule
 * @var PostForm $formModel
 * @var string|null $id
 * @var string|null $imageFile
 * @var array $nodeTree
 * @var SeoForm $seoForm
 * @var string $title
 * @var View $this
 */
$this->title = $title;

$configSummerNote = [
    'config' => [
        'focus' => true,
        'height' => 200,
        'lineHeights' => ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
        'maxHeight' => null,
        'minHeight' => null,
        'placeholder' => 'Write here...',
        'toolbar' => [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
    ],
];
$tabInput = 1;

FontAwesomeAsset::register($this);
?>
<?= Div::widget()->class('container mt-3')->begin() ?>
    <?= Div::widget()->class('row align-items-center justify-content-center')->begin() ?>
        <?= Div::widget()->class('col-md-7 col-sm-12')->begin() ?>
            <?=
                Div::widget()
                    ->class('bg-body-tertiary shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500')
                    ->begin()
            ?>
                <?= H::widget()->content(Encode::content($this->title))->class('fw-bold')->tagName('h1') ?>
                <?= P::widget()->content(Yii::t('yii.blog', 'Please fill out the following fields to create post.')) ?>
                <?= Tag::widget()->class('mb-3')->tagName('hr') ?>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'post-form',
                        'enableAjaxValidation' => true,
                        'layout' => $blogModule->floatLabels ? ActiveForm::LAYOUT_FLOATING : ActiveForm::LAYOUT_DEFAULT,
                        'options' => ['enctype' => 'multipart/form-data'],
                    ]
                ) ?>
                    <?=
                        $form
                            ->field($formModel, 'category_id')
                            ->dropDownList(
                                $nodeTree,
                                [
                                    'class' => 'form-select',
                                    'prompt' => [
                                        'text' => Yii::t('yii.blog', 'Select category'),
                                        'options' => ['value' => '0'],
                                    ],
                                    'tabindex' => $tabInput++,
                                ]
                            )
                    ?>
                    <?= $form->field($formModel, 'title') ?>
                    <?= $form->field($formModel, 'content_short')->widget(Summernote::class, $configSummerNote) ?>
                    <?= $form->field($formModel, 'content')->widget(Summernote::class, $configSummerNote) ?>
                    <?= $form->field($formModel, 'slug') ?>
                    <?=
                        $form
                            ->field(
                                $formModel,
                                'date',
                                [
                                    'errorOptions' => ['class' => 'text-danger'],
                                    'options' => ['class' => 'mt-3']
                                ],
                            )
                            ->label(false)
                            ->widget(
                                DateTimePicker::class,
                                [
                                    'config' => [
                                        'display' => [
                                            'sideBySide' => true,
                                            'icons' => [
                                                'time' => 'fa-solid fa-clock',
                                            ],
                                        ],
                                        'localization' => [
                                            'format' => 'yyyy-MM-dd HH:mm:ss',
                                        ],
                                    ],
                                    'floatingLabel' => true,
                                    'icon' => Icon::renderIcon('solid', 'calendar', ['class' => 'me-2 fa-solid']),
                                ]
                            )
                        ?>
                    <?=
                        $form
                            ->field($formModel, 'tagNames')
                            ->widget(
                                Selectize::class,
                                [
                                    'clientOptions' => [
                                        'plugins' => ['remove_button'],
                                        'valueField' => 'name',
                                        'labelField' => 'name',
                                        'searchField' => ['name'],
                                        'create' => true,
                                    ],
                                    'loadUrl' => ['/tag/collection'],
                                    'type' => Selectize::TYPE_TEXT,
                                ],
                            )
                    ?>
                    <?=
                        $form
                            ->field($formModel, 'image_file')
                            ->widget(
                                FilePond::class,
                                [
                                    'loadFileDefault' => $imageFile,
                                    'imagePreviewHeight' => 170,
                                    'imageCropAspectRatio' => '1:1',
                                ],
                            )
                    ?>
                    <?= SeoWidget::widget(['__construct()' => [$form, $blogModule, $seoForm, $tabInput]]) ?>
                    <?=
                        Div::widget()
                            ->class('d-grid gap-2 col-2')
                            ->content(
                                Button::widget()
                                    ->class('btn btn-lg btn-primary btn-block mt-3')
                                    ->content(Yii::t('yii.blog', 'Save'))
                                    ->name('post-button')
                                    ->submit()
                                    ->tabIndex(9)
                            )
                    ?>
                <?php ActiveForm::end() ?>
            <?= Div::end() ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Div::end();
