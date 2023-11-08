<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use creocoder\nestedsets\NestedSetsBehavior;
use Yii\Blog\Framework\Behavior\SortableBehavior;
use Yii\Blog\Query\CategoryQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

final class Category extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
            ],
            'sorteable' => SortableBehavior::class,
        ];
    }

    public function getPost(): ActiveQuery
    {
        return $this->hasMany(Post::class, ['category_id' => 'id'])->sortDate();
    }

    public function getSeo(): ActiveQuery
    {
        return $this->hasOne(Seo::class, ['item_id' => 'id'])->andWhere(['class' => self::class]);
    }

    public function scenarios(): array
    {
        return array_merge(
            parent::scenarios(),
            [
                'register' => ['title', 'description', 'image_file', 'slug', 'status'],
            ],
        );
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(self::class);
    }

    public static function tableName(): string
    {
        return '{{%categories}}';
    }
}
