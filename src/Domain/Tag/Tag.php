<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Tag;

use yii\db\ActiveRecord;

final class Tag extends ActiveRecord implements TagInterface
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
