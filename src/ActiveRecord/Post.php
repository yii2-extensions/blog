<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

final class Post extends ActiveRecord
{
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])->sort();
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photos::class, ['item_id' => 'id'])->where(['class' => self::className()])->sort();
    }

    public static function tableName(): string
    {
        return '{{%post}}';
    }
}
