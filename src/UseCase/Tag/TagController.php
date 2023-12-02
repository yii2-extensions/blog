<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Tag;

use yii\filters\AccessControl;
use yii\web\Controller;

final class TagController extends Controller
{
    public function actions(): array
    {
        return [
            'collection' => [
                'class' => Collection\CollectionAction::class,
            ],
        ];
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['collection'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
