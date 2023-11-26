<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use Yii2\Extensions\NestedSets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use Yii\Blog\BlogModule;
use Yii\Blog\Framework\Behavior\SortableBehavior;
use Yii\Blog\Query\CategoryQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yiisoft\Strings\Inflector;

use function preg_match;
use function preg_replace;
use function strtolower;

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
            'slug' => [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
                'slugAttribute' => 'slug',
                'value' => function (): string {
                    $slug = (new Inflector)->toSlug($this->title);

                    if (preg_match(BlogModule::SLUG_PATTERN, $slug) === false) {
                        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($this->title));
                    }

                    return $slug;
                },
            ],
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
                'update' => ['title', 'description', 'image_file', 'slug', 'status'],
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
