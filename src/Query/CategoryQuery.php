<?php

declare(strict_types=1);

namespace Yii\Blog\Query;

use creocoder\nestedsets\NestedSetsQueryBehavior;
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
