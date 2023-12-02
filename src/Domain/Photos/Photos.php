<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Photos;

use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $item_id
 * @property string $image_file
 * @property string $description
 * @property string $class
 *
 * @property string $image
*/
final class Photos extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%photos}}';
    }
}
