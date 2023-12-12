<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post\Create;

use RuntimeException;
use Yii2\Extensions\FilePond\FileProcessing;
use Yii;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Domain\Post\PostInterface;
use Yii\Blog\UseCase\Post\PostForm;
use Yii\CoreLibrary\Repository\PersistenceRepository;

final class CreateService
{
    public function __construct(
        private readonly PersistenceRepository $persistenceRepository,
    ) {
    }

    public function run(PostInterface $post, PostForm $postForm): bool
    {
        /** @var Post $post */
        if ($post->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::run()" on existing post.');
        }

        $image_file = $postForm->image_file;
        $postForm->image_file = '';

        $post->setScenario('create');
        $post->setAttributes($postForm->getAttributes());

        if (strtotime($post->date) !== false) {
            $post->date = strtotime($post->date);
        }

        $post->tagNames = $postForm->tagNames;

        $result = $this->persistenceRepository->save($post);

        $postForm->id = $post->id;

        if ($result === false) {
            return false;
        }

        if ($image_file !== null && $image_file !== '') {
            $post->image_file = $this->addImage($post, $image_file);

            return $this->persistenceRepository->update($post);
        }

        return true;
    }

    private function addImage(PostInterface $post, mixed $imageFile): string
    {
        if ($imageFile === null || $imageFile === '') {
            return '';
        }

        return FileProcessing::saveWithReturningFile(
            $imageFile,
            Yii::getAlias('@uploads'),
            "post{$post->id}",
            false,
        );
    }
}
