<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use yii\base\Module;
use Yii\Blog\ActiveRecord\Category;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use yii\data\ArrayDataProvider;
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

    public function __construct(
        $id,
        Module $module,
        private readonly Category $category,
        private readonly CategoryService $categoryService,
        private readonly FinderRepositoryInterface $finderRepository,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
    }

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
                    'register' => ['post'],
                    'update' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(): string
    {
        return $this->render(
            'index',
            [
                'dataProvider' => new ArrayDataProvider(
                    [
                        'allModels' =>$this->categoryService->buildCategoryTree(),
                        'pagination' => [
                            'pageSize' => 5,
                        ],
                    ],
                ),
            ],
        );
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}
