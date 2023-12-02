<?php

declare(strict_types=1);

use PHPForge\Html\Button;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Helper\Encode;
use PHPForge\Html\P;
use PHPForge\Html\Select;
use PHPForge\Html\Tag;
use Yii2\Extensions\FilePond\FilePond;
use Yii\Blog\BlogModule;
use Yii\Blog\UseCase\Category\CategoryForm;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\Blog\UseCase\Seo\SeoWidget;
use yii\bootstrap5\ActiveForm;
use yii\web\View;

/**
 * @var BlogModule $blogModule
 * @var string $buttonTitle
 * @var CategoryForm $formModel
 * @var string|null $id
 * @var string|null $imageFile
 * @var array $nodeTree
 * @var SeoForm $seoForm
 * @var string $title
 * @var View $this
 */
$this->title = $title;
$tabInput = 1;
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
                <?= P::widget()->content(Yii::t('yii.blog', 'Please fill out the following fields to category')) ?>
                <?= Tag::widget()->class('mb-3')->tagName('hr') ?>
                <?php $form = ActiveForm::begin(
                    [
                        'id' => 'category-form',
                        'layout' => $blogModule->floatLabels ? ActiveForm::LAYOUT_FLOATING : ActiveForm::LAYOUT_DEFAULT,
                        'enableAjaxValidation' => true,
                    ],
                ) ?>
                    <?php if ($id !== null) : ?>
                        <?=
                            Select::widget()
                                ->ariaLabel('Select for parent category')
                                ->autofocus()
                                ->class('form-select mt-2')
                                ->id('registerform-title')
                                ->items($nodeTree)
                                ->labelContent(Yii::t('yii.blog', 'Parent category:'))
                                ->name('CategoryForm[parent]')
                                ->tabIndex($tabInput++)
                                ->value($id)
                        ?>
                    <?php endif ?>
                    <?=
                        $form
                            ->field($formModel, 'title')
                            ->textInput(
                                [
                                    'autofocus' => true,
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.blog', 'Enter title Here.') . '")',
                                    'required' => true,
                                    'tabindex' => $tabInput++,
                                ],
                            )
                    ?>
                    <?=
                        $form
                            ->field($formModel, 'description')
                            ->textArea(
                                [
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.blog', 'Enter description Here.') . '")',
                                    'required' => true,
                                    'style' => 'height: 120px',
                                    'tabindex' => $tabInput++,
                                ],
                            )
                    ?>
                    <?=
                        $form
                            ->field($formModel, 'slug')
                            ->textInput(
                                [
                                    'oninvalid' => 'this.setCustomValidity("' . Yii::t('yii.blog', 'Enter slug Here.') . '")',
                                    'required' => false,
                                    'tabindex' => $tabInput++,
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
                            ->class('d-grid gap-2')
                            ->content(
                                Button::widget()
                                    ->class('btn btn-lg btn-primary btn-block mt-3')
                                    ->content($buttonTitle)
                                    ->name('category-button')
                                    ->submit()
                                    ->tabIndex($tabInput++)
                            )
                    ?>
                <?php ActiveForm::end() ?>
            <?= Div::end() ?>
        <?= Div::end() ?>
    <?= Div::end() ?>
<?= Div::end();
