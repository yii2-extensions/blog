<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\EventHandler;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Event;
use Yii\Blog\UseCase\Category\Register\RegisterAction;
use Yii\Blog\UseCase\Category\Register\RegisterEvent;
use yii\web\Application;

final class CategoryRegisterEventHandler implements BootstrapInterface
{
    /**
     * @param Application $app
     */
    public function bootstrap($app): void
    {
        Event::on(
            RegisterAction::class,
            RegisterEvent::AFTER_REGISTER,
            static function (RegisterEvent $registerEvent) use ($app): void {
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
    }
}
