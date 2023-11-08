<?php

declare(strict_types=1);

use yii\web\View;

/**
 * @var View $this
 */
echo $this->render(
    '_form',
    [
        'blogModule' => $blogModule,
        'formModel' => $formModel,
        'id' => $id,
        'nodeTree' => $nodeTree,
        'title' => Yii::t('yii.blog', 'Register category'),
    ],
);
