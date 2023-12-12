<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Seo;

use yii\db\ActiveRecord;

final class Seo extends ActiveRecord implements SeoInterface
{
    public function safeAttributes(): array
    {
        return [
            'keywords',
            'description',
        ];
    }

    public static function tableName(): string
    {
        return 'seo';
    }
}
