<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Delete;

use yii\base\Action;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Service\ApiService;
use Yii\Blog\UseCase\Category\CategoryEvent;
use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;
use yii\web\Controller;
use yii\web\Response;

final class DeleteAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly ApiService $apiService,
        private readonly PersistenceRepositoryInterface $persistenceRepository,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $slug = null): string|Response
    {
        /** @var Category $category */
        $category = $this->apiService->getCategoryBySlug($slug);

        $id = $category->id ?? null;
        $registerEvent = new CategoryEvent($id);

        if ($category === null) {
            $this->trigger(CategoryEvent::NOT_FOUND, $registerEvent);

            return $this->controller->redirect(['category/index']);
        }

        $this->trigger(CategoryEvent::BEFORE_DELETE, $registerEvent);

        if ($category->depth === 0 && $category->deleteWithChildren() > 0) {
            $this->trigger(CategoryEvent::DELETE_NODE_CATEGORY, $registerEvent);

            return $this->controller->redirect(['category/index']);
        }

        match ($this->persistenceRepository->delete($category)) {
            true => $this->trigger(CategoryEvent::AFTER_DELETE, $registerEvent),
            false => $this->trigger(CategoryEvent::DELETE_ERROR, $registerEvent),
        };

        return $this->controller->redirect(['category/index']);
    }
}
