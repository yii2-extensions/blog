<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Tag;

use yii\db\ActiveRecord;

final class TagItem extends ActiveRecord implements TagItemInterface
{
    public static function tableName()
    {
        return '{{%tag_item}}';
    }
}
