<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Category;

use Yii2\Extensions\NestedSets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

final class CategoryQuery extends ActiveQuery
{
    public function behaviors(): array
    {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }
}
