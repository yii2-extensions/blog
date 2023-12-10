<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Blog\Index;

use yii\base\Action;
use Yii\Blog\Service\ApiService;
use yii\web\Controller;
use yii\web\Request;
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
        $pageSize = 5;

        if ($this->controller->request instanceof Request) {
            $pageSize = (int) $this->controller->request->get('per-page', $pageSize);
        }

        return $this->controller->render(
            'posts/index',
            [
                'posts' => $this->apiService->preparePostDataProvider($pageSize)
            ],
        );
    }
}
