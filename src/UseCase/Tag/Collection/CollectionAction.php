<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Tag\Collection;

use yii\base\Action;
use Yii\Blog\Domain\Tag\TagInterface;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use yii\web\Controller;
use yii\web\Response;

final class CollectionAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly FinderRepositoryInterface $finderRepository,
        private readonly TagInterface $tag,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $query = ''): array
    {
        $this->controller->response->format = Response::FORMAT_JSON;

        $items = [];

        $query = urldecode(mb_convert_encoding($query, "UTF-8"));
        $tags = $this->finderRepository->findByWhereCondition($this->tag, ['like', 'name', $query])->asArray()->all();

        foreach ($tags as $tag) {
            $items[] = ['name' => $tag['name']];
        }

        return $items;
    }
}
