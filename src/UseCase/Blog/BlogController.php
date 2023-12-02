<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Blog;

use yii\filters\AccessControl;
use yii\web\Controller;

final class BlogController extends Controller
{
    public $layout = '@resource/layout/main';
    public string $viewPath = __DIR__ . '/view';

    public function actions(): array
    {
        return [
            'index' => [
                'class' => Index\IndexAction::class,
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
                        'actions' => ['index'],
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}