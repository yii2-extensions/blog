<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use yii\db\ActiveRecord;

final class Tag extends ActiveRecord
{
    public function safeAttributes(): array
    {
        return [
            'name',
            'frequency',
        ];
    }

    public static function tableName()
    {
        return '{{%tag}}';
    }
}
