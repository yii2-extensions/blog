<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Seo;

use Yii;
use yii\base\Model;

final class SeoForm extends Model
{
    public string|null $keywords = '';
    public string|null $description = '';

    public function rules(): array
    {
        return [
            ['keywords', 'string', 'max' => 255],
            ['description', 'string', 'max' => 1024],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'keywords' => Yii::t('yii.blog', 'Seo Keywords'),
            'description' => Yii::t('yii.blog', 'Seo Description'),
        ];
    }
}
