<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\Asset;

use yii\web\AssetBundle;

/**
 * Asset bundle for the web application.
 **/
final class BlogAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/../resource/';

    public $css = [
        'css/style.css',
    ];

    public $publishOptions = [
        'only' => [
            'style.css',
        ],
    ];
}
