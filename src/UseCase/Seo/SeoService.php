<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Seo;

use RuntimeException;
use Yii\Blog\ActiveRecord\Seo;
use Yii\CoreLibrary\Repository\PersistenceRepositoryInterface;

final class SeoService
{
    public function __construct(
        private readonly PersistenceRepositoryInterface $persistenceRepository,
        private readonly Seo $seo,
    ) {
    }

    public function run(SeoForm $seoForm, string $class, int $itemId): bool
    {
        if ($this->seo->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::run()" on existing category.');
        }

        $this->seo->setAttributes($seoForm->getAttributes(), false);
        $this->seo->class = $class;
        $this->seo->item_id = $itemId;

        return $this->persistenceRepository->save($this->seo);
    }
}
