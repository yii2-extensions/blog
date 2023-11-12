<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\EventHandler;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use Yii\Blog\UseCase\Category\CategoryEvent;
use Yii\Blog\UseCase\Category\Delete\DeleteAction;
use Yii\Blog\UseCase\Category\Enable\EnableAction;
use Yii\Blog\UseCase\Category\Register\RegisterAction;
use Yii\Blog\UseCase\Category\Update\UpdateAction;
use yii\web\Application;

final class CategoryRegisterEventHandler implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app): void
    {
        Event::on(
            DeleteAction::class,
            CategoryEvent::AFTER_DELETE,
            static function () use ($app): void {
                $app->session->setFlash('success', Yii::t('yii.blog', 'Your category has been successfully deleted.'));
            },
        );

        Event::on(
            DeleteAction::class,
            CategoryEvent::DELETE_ERROR,
            static function () use ($app): void {
                $app->session->setFlash('danger', Yii::t('yii.blog', 'Your category has not been deleted.'));
            },
        );

        Event::on(
            DeleteAction::class,
            CategoryEvent::DELETE_NODE_CATEGORY,
            static function () use ($app): void {
                $app->session->setFlash(
                    'success',
                    Yii::t('yii.blog', 'Your category and its sub categories have been successfully deleted.'),
                );
            },
        );

        Event::on(
            EnableAction::class,
            CategoryEvent::AFTER_STATUS_ACTIVE,
            static function () use ($app): void {
                $app->session->setFlash('success', Yii::t('yii.blog', 'Your category has been successfully enabled.'));
            },
        );

        Event::on(
            RegisterAction::class,
            CategoryEvent::AFTER_REGISTER,
            static function (CategoryEvent $registerEvent) use ($app): void {
                match ($registerEvent->id) {
                    null => $app->session->setFlash(
                        'success',
                        Yii::t('yii.blog', 'Your principal category has been successfully registered.'),
                    ),
                    default => $app->session->setFlash(
                        'success',
                        Yii::t('yii.blog', 'Your sub category has been successfully registered.'),
                    ),
                };
            },
        );

        Event::on(
            UpdateAction::class,
            CategoryEvent::AFTER_UPDATE,
            static function () use ($app): void {
                $app->session->setFlash('success', Yii::t('yii.blog', 'Your category has been successfully updated.'));
            },
        );

        Event::on(
            UpdateAction::class,
            CategoryEvent::NOT_FOUND,
            static function () use ($app): void {
                $app->session->setFlash('danger', Yii::t('yii.blog', 'Your category has not been found.'));
            },
        );
    }
}
