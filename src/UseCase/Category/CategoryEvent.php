<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use yii\base\Event;

final class CategoryEvent extends Event
{
    public const AFTER_DELETE = 'afterDelete';
    public const AFTER_REGISTER = 'afterRegister';
    public const AFTER_STATUS_ACTIVE = 'afterStatusActive';
    public const AFTER_STATUS_DISABLE = 'afterStatusDisable';
    public const AFTER_UPDATE = 'afterUpdate';
    public const BEFORE_DELETE = 'beforeDelete';
    public const BEFORE_REGISTER = 'beforeRegister';
    public const BEFORE_STATUS_ACTIVE = 'beforeStatusActive';
    public const BEFORE_STATUS_DISABLE = 'beforeStatusDisable';
    public const BEFORE_UPDATE = 'beforeUpdate';
    public const DELETE_ERROR = 'deleteError';
    public const DELETE_NODE_CATEGORY = 'deleteNodeCategory';
    public const NOT_FOUND = 'notFound';
    public const NOT_UPDATE = 'notUpdate';

    public function __construct(public readonly string|int|null $id = null)
    {
    }
}
