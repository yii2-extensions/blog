<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Blog\Post;

use yii\base\Action;
use Yii\Blog\Service\ApiService;
use yii\web\Controller;
use yii\web\Response;

final class PostAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly ApiService $apiService,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $slug = ''): string|Response
    {
        $post = $this->apiService->getPostBySlug($slug);

        return $this->controller->render(
            'post/index',
            [
                'post' => $post,
            ],
        );
    }
}
