<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

final class PostController extends Controller
{
    /**
     * @phpstan-var class-string<PostForm>
     */
    public string $formModelClass = PostForm::class;
    public $layout = '@resource/layout/main';
    public string $viewPath = __DIR__ . '/view';

    public function actions(): array
    {
        return [
            'create' => [
                'class' => Create\CreateAction::class,
            ],
            'index' => [
                'class' => Index\IndexAction::class,
            ],
            'update' => [
                'class' => Update\UpdateAction::class,
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
                        'actions' => ['create', 'delete', 'disable', 'enable', 'index', 'update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                    'disable' => ['post'],
                    'enable' => ['post'],
                ],
            ],
        ];
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}
