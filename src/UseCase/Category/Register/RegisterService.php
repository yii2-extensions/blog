<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Register;

use RuntimeException;
use Yii\Blog\ActiveRecord\Category;
use Yii\Blog\UseCase\Category\CategoryForm;
use Yii\CoreLibrary\Repository\FinderRepository;

final class RegisterService
{
    public function __construct(
        private readonly Category $category,
        private readonly FinderRepository $finderRepository,
    ) {
    }

    public function run(CategoryForm $categoryForm, string $parent = null): bool
    {
        if ($this->category->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::run()" on existing category.');
        }

        $this->category->setScenario('register');
        $this->category->setAttributes($categoryForm->getAttributes(), false);

        if ($parent !== null && $categoryForm->parent === $parent) {
            $parentCategory = $this->finderRepository->findById($this->category, (int) $parent);

            if ($parentCategory === null) {
                throw new RuntimeException('Parent category not found.');
            }

            $result = $this->category->prependTo($parentCategory);
            $categoryForm->id = $this->category->id;

            return $result;
        }

        $result = $this->category->makeRoot();
        $categoryForm->id = $this->category->id;

        return $result;
    }
}
