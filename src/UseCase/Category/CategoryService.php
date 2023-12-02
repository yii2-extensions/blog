<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use Yii\Blog\Domain\Category\CategoryInterface;
use Yii\Blog\Domain\Category\CategoryQuery;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;

final class CategoryService
{
    public function __construct(
        private readonly CategoryInterface $category,
        private readonly FinderRepositoryInterface $finderRepository
    ) {
    }

    public function buildCategoryTree(): array
    {
        $collection = $this->finderRepository
            ->findByWhereCondition($this->category, [])
            ->orderBy('tree')
            ->with('seo')
            ->asArray()
            ->all();

        $flat = [];

        foreach ($collection as $node) {
            $node = (object) $node;
            $id = $node->id;
            $node->parent = '';

            foreach ($flat as $temp) {
                if ($temp->depth === $node->depth - 1) {
                    $node->parent = $temp->id;
                    break;
                }
            }

            unset($node->lft, $node->rgt);

            $flat[$id] = $node;
        }

        foreach ($flat as $node) {
            $node->children = [];

            foreach ($flat as $temp) {
                if ($temp->parent === $node->id) {
                    $node->children[] = $temp->id;
                }
            }
        }

        return $flat;
    }

    public function buildNodeTree(): array
    {
        $items = [];

        foreach($this->getNodes() as $node) {
            $items[$node->id] = $node->title;
        }

        return $items;
    }

    public function buildNodeTreeWithDepth(): array
    {
        $items = [];

        foreach($this->getNodes() as $node) {
            $items[$node->id] = $node->title;

            foreach($this->getLeaves() as $leaf) {
                $items[$leaf->id] = $leaf->title;
            }
        }

        return $items;
    }

    private function getLeaves(): array
    {
        /** @var CategoryQuery $categoryQuery */
        $categoryQuery = $this->finderRepository->find($this->category);

        return $categoryQuery->leaves()->all();
    }

    private function getNodes(): array
    {
        /** @var CategoryQuery $categoryQuery */
        $categoryQuery = $this->finderRepository->find($this->category);

        return $categoryQuery->roots()->all();
    }
}
