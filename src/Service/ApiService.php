<?php

declare(strict_types=1);

namespace Yii\Blog\Service;

use Yii;
use Yii\Blog\Domain\Category\CategoryInterface;
use Yii\Blog\Domain\Post\PostInterface;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecordInterface;
use yii\helpers\Url;

use function file_exists;

final class ApiService
{
    public function __construct(
        private readonly CategoryInterface $category,
        private readonly CategoryService $categoryService,
        private readonly FinderRepositoryInterface $finderRepository,
        private readonly PostInterface $post,
    ) {
    }

    public function getCategoryBySlug(string $slug): array|null|ActiveRecordInterface
    {
        return $this->finderRepository->findByOneCondition($this->category, ['slug' => $slug]);
    }

    /**
     * @phpstan-return CategoryInterface[]
     */
    public function getCategories(): array
    {
        return $this->finderRepository->find($this->category)->orderBy(['id' => SORT_DESC])->all();
    }

    public function getImageCardX(string $slug): string
    {
        $post = $this->finderRepository->findByOneCondition($this->post, ['slug' => $slug]);

        $dirImage = Yii::getAlias('@image');
        $dirResource = dirname(__DIR__) . '/Framework/resource/';

        $file = "$dirImage/cardx-$post->id.png";
        $fileCardDefault = "$dirResource/image/cardx.png";

        if (file_exists($fileCardDefault) === false) {
            copy($fileCardDefault, "$dirImage/cardx.png");
        }

        return file_exists($file)
            ? Url::to(["/image/cardx-$post->id.png", 'time' => $post->date], true)
            : '/image/cardx.png';
    }

    public function getPostBySlug(string $slug): array|null|ActiveRecordInterface
    {
        return $this->finderRepository->findByOneCondition($this->post, ['slug' => $slug]);
    }

    public function getTrending(int $limit = 3): array
    {
        return $this->finderRepository->find($this->post)->orderBy(['id' => SORT_DESC])->limit($limit)->all();
    }

    public function prepareCategoryDataProvider(): ArrayDataProvider
    {
        return new ArrayDataProvider(
            [
                'allModels' =>$this->categoryService->buildCategoryTree(),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ],
        );
    }

    public function preparePostDataProvider(int $pageSize = 5): ActiveDataProvider
    {
        return new ActiveDataProvider(
            [
                'query' => $this->finderRepository->find($this->post)->orderBy(['id' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => $pageSize,
                ],
            ],
        );
    }
}
