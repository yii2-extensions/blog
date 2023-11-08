<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\Validator;

use yii\validators\Validator;

final class EscapeValidator extends Validator
{
    public function validateAttribute($model, $attribute): void
    {
        $value = $model->$attribute;

        if (is_string($value)) {
            $model->$attribute = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }
    }
}
