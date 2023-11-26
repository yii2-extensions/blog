<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Seo;

use yii\base\Widget;
use Yii\Blog\BlogModule;
use yii\bootstrap5\ActiveForm;

final class SeoWidget extends Widget
{
    public string $viewPath = __DIR__ . '/view';

    public function __construct(
        private readonly ActiveForm $form,
        private readonly BlogModule $blogModule,
        private readonly SeoForm $seoForm,
        private int $tabInput = 1,
        $config = []
    ) {
        parent::__construct($config);
    }

    public function run(): string
    {
        return $this->render(
            'index',
            [
                'blogModule' => $this->blogModule,
                'form' => $this->form,
                'formModel' => $this->seoForm,
                'tabInput' => $this->tabInput,
            ],
        );
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }
}
