<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Index;

use yii\base\Action;
use Yii\Blog\Service\ApiService;
use yii\web\Controller;
use yii\web\Response;

final class IndexAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly ApiService $apiService,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(): string|Response
    {
        return $this->controller->render('index', ['dataProvider' => $this->apiService->prepareCategoryDataProvider()]);
    }
}
