<?php

declare(strict_types=1);

namespace Yii\Blog;

use yii\base\Module;

final class BlogModule extends Module
{
    public const PHOTO_THUMB_WIDTH = 120;
    public const PHOTO_THUMB_HEIGHT = 90;
    public const STATUS_OFF = 0;
    public const STATUS_ON = 1;

    public function __construct(
        $id,
        Module $module,
        public readonly bool $floatLabels = true,
        public readonly string $slugPattern = '/^[0-9a-z-]{0,128}$/',
        array $config = [],
    ) {
        parent::__construct($id, $module, $config);
    }
}
