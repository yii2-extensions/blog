<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post\Create;

use RuntimeException;
use Yii2\Extensions\FilePond\FileProcessing;
use Yii;
use Yii\Blog\ActiveRecord\Post;
use Yii\Blog\UseCase\Post\PostForm;
use Yii\CoreLibrary\Repository\FinderRepository;
use Yii\CoreLibrary\Repository\PersistenceRepository;

final class CreateService
{
    public function __construct(
        private readonly FinderRepository $finderRepository,
        private readonly PersistenceRepository $persistenceRepository,
        private readonly Post $post,
    ) {
    }

    public function run(PostForm $postForm): bool
    {
        if ($this->post->getIsNewRecord() === false) {
            throw new RuntimeException('Calling "' . __CLASS__ . '::run()" on existing post.');
        }

        $image_file = $postForm->image_file;
        $postForm->image_file = '';

        $this->post->setScenario('create');
        $this->post->setAttributes($postForm->getAttributes(), false);

        if (strtotime($this->post->date) !== false) {
            $this->post->date = (string) strtotime($this->post->date);
        }

        if ($this->persistenceRepository->save($this->post) === false) {
            return false;
        }

        $this->post->image_file = $this->addImage($image_file);

        return $this->persistenceRepository->update($this->post);
    }

    private function addImage(mixed $imageFile): string
    {
        if ($imageFile === null) {
            return '';
        }

        return FileProcessing::saveWithReturningFile(
            $imageFile,
            Yii::getAlias('@uploads'),
            "post{$this->post->id}",
            false,
        );
    }
}
