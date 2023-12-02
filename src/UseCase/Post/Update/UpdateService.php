<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post\Update;

use Yii2\Extensions\FilePond\FileProcessing;
use Yii;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Domain\Post\PostInterface;
use Yii\Blog\UseCase\Post\PostForm;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\CoreLibrary\Repository\PersistenceRepository;

final class UpdateService
{
    public function __construct(
        private readonly PersistenceRepository $persistenceRepository,
    ) {
    }

    public function run(PostInterface $post, PostForm $postForm, SeoForm $seoForm): bool
    {
        if (strtotime($postForm->date) !== false) {
            $postForm->date = (string) strtotime($postForm->date);
        }

        if ($postForm->image_file !== null && $postForm->image_file !== '') {
            $postForm->image_file = FileProcessing::saveWithReturningFile(
                $postForm->image_file,
                Yii::getAlias('@uploads'),
                "category{$post->id}",
                false
            );
        }

        /** @var Post $post */
        $post->setScenario('update');
        $post->setAttributes($postForm->getAttributes(), false);

        $post->tagNames = $postForm->tagNames;
        $seo = $post->seo;

        $seo->setAttributes($seoForm->getAttributes());

        return ($this->persistenceRepository->update($post) || $this->persistenceRepository->update($seo));
    }
}
