<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post;

use yii\base\Event;

final class PostEvent extends Event
{
    public const AFTER_CREATE = 'afterCreate';
    public const AFTER_UPDATE = 'afterUpdate';
    public const BEFORE_CREATE = 'beforeCreate';
    public const BEFORE_UPDATE = 'beforeUpdate';
    public const NOT_FOUND = 'notFound';
    public const NOT_UPDATE = 'notUpdate';
}
