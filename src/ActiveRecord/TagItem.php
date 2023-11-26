<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use yii\db\ActiveRecord;

final class TagItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag_item}}';
    }
}
