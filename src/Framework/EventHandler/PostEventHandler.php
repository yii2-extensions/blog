<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\EventHandler;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use Yii\Blog\UseCase\Post\PostEvent;
use Yii\Blog\UseCase\Post\Update\UpdateAction;
use yii\web\Application;

final class PostEventHandler implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app): void
    {
        Event::on(
            UpdateAction::class,
            PostEvent::AFTER_UPDATE,
            static function () use ($app): void {
                $app->session->setFlash('success', Yii::t('yii.blog', 'Your post has been successfully updated.'));
            },
        );
    }
}
