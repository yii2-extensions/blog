<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Register;

use RuntimeException;
use Yii2\Extensions\FilePond\FileProcessing;
use Yii;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Category\CategoryInterface;
use Yii\Blog\UseCase\Category\CategoryForm;
use Yii\CoreLibrary\Repository\FinderRepository;
use Yii\CoreLibrary\Repository\PersistenceRepository;

final class RegisterService
{
    public function __construct(
        private readonly FinderRepository $finderRepository,
        private readonly PersistenceRepository $persistenceRepository,
    ) {
    }

    public function run(CategoryInterface $category, CategoryForm $categoryForm, string $parent = null): bool
    {
        /** @var Category $category */
        if ($category->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::run()" on existing category.');
        }

        $imageFile = is_array($categoryForm->image_file) ? $categoryForm->image_file : [];
        $categoryForm->image_file = '';

        $category->setScenario('register');
        $category->setAttributes($categoryForm->getAttributes(), false);

        if ($parent !== null && $categoryForm->parent === $parent) {
            $parentCategory = $this->finderRepository->findById($category, (int) $parent);

            if ($parentCategory === null) {
                throw new RuntimeException('Parent category not found.');
            }

            $result = $category->prependTo($parentCategory);
            $categoryForm->id = $category->id;

            $this->addImage($category, $imageFile);

            return $result;
        }

        $result = $category->makeRoot();
        $categoryForm->id = $category->id;

        $this->addImage($category, $imageFile);

        return $result;
    }

    private function addImage(CategoryInterface $category, array $imageFile): void
    {
        $category->image_file = FileProcessing::saveWithReturningFile(
            $imageFile,
            Yii::getAlias('@uploads'),
            "category{$category->id}",
            false,
        );

        $this->persistenceRepository->update($category);
    }
}
