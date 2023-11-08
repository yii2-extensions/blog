<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use yii\base\Module;
use Yii\Blog\ActiveRecord\Category;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use yii\data\ArrayDataProvider;
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
            'register' => [
                'class' => Register\RegisterAction::class,
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
