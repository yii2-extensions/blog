<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\db\ActiveRecord;
use yii\web\View;

/**
 * @var ActiveRecord[] $trendings
 * @var View $this
 */
BlogAsset::register($this);

$items = [];

echo Div::widget()
    ->class('container-xxl px-4 px-xxl-2')
    ->content(
        Div::widget()
            ->class('d-lg-grid content')
            ->content(
                $this->render('../_sidebar'),
                $this->render('_archive', ['trendings' => $trendings]),
            )
            ->id('content')
    );
