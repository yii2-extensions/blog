<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post;

use yii\base\Event;

final class PostEvent extends Event
{
    public const AFTER_CREATE = 'afterCreate';
    public const BEFORE_CREATE = 'beforeCreate';
}
