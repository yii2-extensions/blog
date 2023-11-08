<?php

declare(strict_types=1);

namespace Yii\Blog\Widget\Seo;

use yii\base\Widget;
use Yii\Blog\BlogModule;
use Yii\Blog\Widget\Seo\SeoForm;
use yii\bootstrap5\ActiveForm;

final class SeoWidget extends Widget
{
    public string $viewPath = __DIR__ . '/view';

    public function __construct(
        private readonly ActiveForm $form,
        private readonly BlogModule $blogModule,
        private int $tabInput = 1,
        $config = []
    ) {
        parent::__construct($config);
    }

    public function run(): string
    {
        $seoModel = new SeoForm();

        return $this->render(
            'index',
            [
                'blogModule' => $this->blogModule,
                'form' => $this->form,
                'formModel' => $seoModel,
                'tabInput' => $this->tabInput,
            ],
        );
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}
