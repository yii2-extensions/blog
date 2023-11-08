<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Register;

use yii\base\Action;
use yii\base\Model;
use Yii\Blog\ActiveRecord\Category;
use Yii\Blog\BlogModule;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\Blog\Widget\Seo\SeoForm;
use Yii\Blog\Widget\Seo\SeoService;
use Yii\CoreLibrary\Validator\AjaxValidator;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

final class RegisterAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly AjaxValidator $ajaxValidator,
        private readonly BlogModule $blogModule,
        private readonly CategoryService $categoryService,
        private readonly RegisterService $registerService,
        private readonly Request $request,
        private readonly SeoService $seoService,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(string $id = null): string|Response
    {
        $categoryForm = new $this->controller->formModelClass($this->blogModule);
        $this->ajaxValidator->validate($categoryForm);

        $registerEvent = new RegisterEvent($id);
        $this->trigger(RegisterEvent::BEFORE_REGISTER, $registerEvent);

        $seoForm = new SeoForm();

        if (
            $categoryForm->load($this->request->post()) &&
            $seoForm->load($this->request->post()) &&
            $categoryForm->validate() &&
            $this->registerService->run($categoryForm, $id) &&
            $this->seoService->run($seoForm, Category::class, $categoryForm->id)
        ) {
            $this->trigger(RegisterEvent::AFTER_REGISTER, $registerEvent);

            return $this->controller->redirect(['category/index']);
        }

        return $this->controller->render(
            'register',
            [
                'blogModule' => $this->blogModule,
                'formModel' => $categoryForm,
                'nodeTree' => $this->categoryService->buildNodeTree(),
                'id' => $id,
            ],
        );
    }
}
