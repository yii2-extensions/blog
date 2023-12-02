<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

final class CategoryController extends Controller
{
    /**
     * @phpstan-var class-string<CategoryForm>
     */
    public string $formModelClass = CategoryForm::class;
    public $layout = '@resource/layout/main';
    public string $viewPath = __DIR__ . '/view';

    public function actions(): array
    {
        return [
            'delete' => [
                'class' => Delete\DeleteAction::class,
            ],
            'disable' => [
                'class' => Disable\DisableAction::class,
            ],
            'enable' => [
                'class' => Enable\EnableAction::class,
            ],
            'index' => [
                'class' => Index\IndexAction::class,
            ],
            'register' => [
                'class' => Register\RegisterAction::class,
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
                        'actions' => ['delete', 'disable', 'enable', 'index', 'register', 'update'],
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
