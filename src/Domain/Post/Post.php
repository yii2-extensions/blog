<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Post;

use yii\behaviors\SluggableBehavior;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Seo\Seo;
use Yii\Blog\Framework\Behavior\Taggable;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yiisoft\Strings\Inflector;

use function preg_match;
use function preg_replace;
use function strtolower;

final class Post extends ActiveRecord implements PostInterface
{
    public function behaviors(): array
    {
        return [
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
            'taggable' => Taggable::class,
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getSeo(): ActiveQuery
    {
        return $this->hasOne(Seo::class, ['item_id' => 'id'])->andWhere(['class' => self::class]);
    }

    public function scenarios(): array
    {
        $attributes = [
            'category_id',
            'title',
            'content',
            'content_short',
            'date',
            'status',
            'tagNames',
        ];

        return array_merge(parent::scenarios(), ['create' => $attributes, 'update' => $attributes]);
    }

    public static function tableName(): string
    {
        return '{{%post}}';
    }
}
