<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Update;

use Yii2\Extensions\FilePond\FileProcessing;
use Yii;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Category\CategoryInterface;
use Yii\Blog\UseCase\Category\CategoryForm;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\CoreLibrary\Repository\PersistenceRepository;

final class UpdateService
{
    public function __construct(
        private readonly PersistenceRepository $persistenceRepository,
    ) {
    }

    public function run(CategoryInterface $category, CategoryForm $categoryForm, SeoForm $seoForm): bool
    {
        $categoryForm->image_file = FileProcessing::saveWithReturningFile(
            $categoryForm->image_file,
            Yii::getAlias('@uploads'),
            "category{$category->id}",
            false
        );

        /** @var Category $category */
        $category->setScenario('update');
        $category->setAttributes($categoryForm->getAttributes());

        $seo = $category->seo;
        $seo->setAttributes($seoForm->getAttributes());

        return ($this->persistenceRepository->update($category) || $this->persistenceRepository->update($seo));
    }
}
