<?php

declare(strict_types=1);

use Yii\Blog\BlogModule;
use Yii\Blog\UseCase\Category\CategoryForm;
use Yii\Blog\Widget\Seo\SeoForm;
use yii\web\View;

/**
 * @var BlogModule $blogModule
 * @var string $buttonTitle
 * @var CategoryForm $form
 * @var string $id
 * @var array $nodeTree
 * @var SeoForm $seoForm
 * @var string $title
 * @var View $this
 */
echo $this->render(
    '_form',
    [
        'blogModule' => $blogModule,
        'buttonTitle' => $buttonTitle,
        'formModel' => $formModel,
        'id' => $id,
        'nodeTree' => $nodeTree,
        'seoForm' => $seoForm,
        'title' => $title,
    ],
);
