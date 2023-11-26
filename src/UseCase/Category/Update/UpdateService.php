<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Update;

use Yii2\Extensions\FilePond\FileProcessing;
use Yii;
use Yii\Blog\ActiveRecord\Category;
use Yii\Blog\UseCase\Category\CategoryForm;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\CoreLibrary\Repository\PersistenceRepository;

final class UpdateService
{
    public function __construct(
        private readonly PersistenceRepository $persistenceRepository,
    ) {
    }

    public function run(Category $category, CategoryForm $categoryForm, SeoForm $seoForm): bool
    {
        $categoryForm->image_file = FileProcessing::saveWithReturningFile(
            $categoryForm->image_file,
            Yii::getAlias('@uploads'),
            "category{$category->id}",
            false
        );

        $category->setScenario('update');
        $category->setAttributes($categoryForm->getAttributes());

        $seo = $category->seo;
        $seo->setAttributes($seoForm->getAttributes());

        return ($this->persistenceRepository->update($category) || $this->persistenceRepository->update($seo));
    }
}
