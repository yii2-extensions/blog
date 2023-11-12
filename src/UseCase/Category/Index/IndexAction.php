<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Index;

use yii\base\Action;
use Yii\Blog\UseCase\Category\CategoryService;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\Response;

final class IndexAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly CategoryService $categoryService,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(): string|Response
    {
        return $this->controller->render(
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
}
