<?php

declare(strict_types=1);

use PHPForge\Html\A;
use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Img;
use PHPForge\Html\P;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var string $action
 * @var string $categoryTitle
 * @var int $postCount
 * @var string $slug
 * @var View $this
 */
$items = [];

echo Div::widget()
    ->class('sidebar')
    ->content(
        Div::widget()
            ->class('masthead py-5')
            ->content(
                Div::widget()
                    ->class('mb-4 text-center text-lg-start')
                    ->content(
                        A::widget()
                            ->ariaLabel('YiiVerse')
                            ->class('flex-shrink-0 mb-lg-3 link-dark text-decoration-none')
                            ->content(
                                Img::widget()
                                    ->alt('YiiVerse')
                                    ->class('bd-booticon d-block mx-auto mb-3 mx-lg-0')
                                    ->src('/image/yii.png')
                                    ->width(200)
                            )
                            ->href(Url::to(['/blog/index'])),
                        Div::widget()
                            ->class('my-3 my-lg-0')
                            ->content(
                                H::widget()->class('mb-1 mb-lg-2 f1 fw-600')->content('YiiVerse Blog')->tagName('h1'),
                                P::widget()->
                                    content(
                                        Yii::t(
                                            'yii.blog',
                                            'Stay updated with the latest news and announcements on YiiFramework.'
                                        ),
                                        "\n",
                                        Yii::t(
                                            'yii.blog',
                                            'Discover new releases, fresh articles, updated wikis, and engage in general',
                                        ),
                                        "\n",
                                        Yii::t(
                                            'yii.blog',
                                            'discussions within the Yii community.',
                                        ),
                                        ' ',
                                        A::widget()
                                            ->content('Explore now')
                                            ->href('https://yiiframework.com/')
                                            ->title('YiiFramework')
                                    )
                            )
                    ),
                $this->render(
                    '_menu-sidebar',
                    [
                        'action' => $action,
                        'categoryTitle' => $categoryTitle,
                        'postCount' => $postCount,
                        'slug' => $slug
                    ],
                ),
            ),
    );
