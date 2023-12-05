<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Seo;

use RuntimeException;
use Yii\Blog\Domain\Seo\Seo;
use Yii\Blog\Domain\Seo\SeoInterface;
use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;

final class SeoService
{
    public function __construct(private readonly PersistenceRepositoryInterface $persistenceRepository)
    {
    }

    public function run(SeoInterface $seo, SeoForm $seoForm, string $class, int $itemId): bool
    {
        /** @var Seo $seo */
        if ($seo->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::run()" on existing category.');
        }

        $seo->setAttributes($seoForm->getAttributes(), false);
        $seo->class = $class;
        $seo->item_id = $itemId;

        return $this->persistenceRepository->save($seo);
    }
}
