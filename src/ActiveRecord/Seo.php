<?php

declare(strict_types=1);

namespace Yii\Blog\ActiveRecord;

use yii\db\ActiveRecord;

final class Seo extends ActiveRecord
{
    public function safeAttributes(): array
    {
        return [
            'h1',
            'title',
            'keywords',
            'title',
        ];
    }

    public static function tableName(): string
    {
        return 'seo';
    }
}
