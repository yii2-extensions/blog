<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Category;

use Yii2\Extensions\NestedSets\NestedSetsBehavior;
use yii\behaviors\SluggableBehavior;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Domain\Seo\Seo;
use Yii\Blog\Framework\Behavior\SortableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yiisoft\Strings\Inflector;

use function preg_match;
use function preg_replace;
use function strtolower;

final class Category extends ActiveRecord implements CategoryInterface
{
    public function behaviors(): array
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
            ],
            'sortable' => SortableBehavior::class,
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
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }

    public function getSeo(): ActiveQuery
    {
        return $this->hasOne(Seo::class, ['item_id' => 'id'])->andWhere(['class' => CategoryInterface::class]);
    }

    public function scenarios(): array
    {
        $attributes = [
            'title',
            'description',
            'image_file',
            'slug',
            'status',
        ];

        return array_merge(parent::scenarios(), ['register' => $attributes, 'update' => $attributes]);
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
