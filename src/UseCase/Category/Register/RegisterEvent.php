<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Register;

use yii\base\Event;

final class RegisterEvent extends Event
{
    public const AFTER_REGISTER = 'afterRegister';
    public const BEFORE_REGISTER = 'beforeRegister';

    public function __construct(public readonly string|null $id = null)
    {
    }
}
