<?php

declare(strict_types=1);

use Yiisoft\Config\Config;
use Yiisoft\Config\ConfigPaths;
use Yiisoft\Config\Modifier\RecursiveMerge;

$rootDir = dirname(__DIR__, 2);

$config = new Config(
    new ConfigPaths($rootDir, 'config', 'vendor'),
    'tests',
    [RecursiveMerge::groups('web', 'params-web')],
    'params-web',
);

return $config->get('web');
