<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use yii\behaviors\SluggableBehavior;
use Yii\Blog\BlogModule;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use Yiisoft\Strings\Inflector;

final class Post extends ActiveRecord
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
        ];
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])->sort();
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photos::class, ['item_id' => 'id'])->where(['class' => self::className()])->sort();
    }

    public function scenarios(): array
    {
        return array_merge(
            parent::scenarios(),
            [
                'create' => [
                    'category_id',
                    'title',
                    'content',
                    'content_short',
                    'date',
                    'status',
                ],
            ],
        );
    }

    public static function tableName(): string
    {
        return '{{%post}}';
    }
}
