<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use Yii\Blog\ActiveRecord\Category;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;

final class CategoryService
{
    public function __construct(
        private readonly Category $category,
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
                if ($temp->depth == $node->depth - 1) {
                    $node->parent = $temp->id;
                    break;
                }
            }

            unset($node->lft, $node->rgt);

            $flat[$id] = $node;
        }

        foreach ($flat as &$node) {
            $node->children = [];

            foreach ($flat as $temp) {
                if ($temp->parent == $node->id) {
                    $node->children[] = $temp->id;
                }
            }
        }

        return $flat;
    }

    public function buildNodeTree(): array
    {
        $items = [];

        foreach($this->category->find()->roots()->all() as $node) {
            $items[$node->id] = $node->title;
        }

        return $items;
    }
}
