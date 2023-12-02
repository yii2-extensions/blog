<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Register;

use Yii;
use yii\base\Action;
use yii\base\ExitException;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Seo\SeoInterface;
use Yii\Blog\UseCase\Category\CategoryEvent;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\Blog\UseCase\Seo\SeoService;
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
        private readonly Category $category,
        private readonly CategoryService $categoryService,
        private readonly RegisterService $registerService,
        private readonly Request $request,
        private readonly SeoInterface $seo,
        private readonly SeoService $seoService,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    /**
     * @throws ExitException
     */
    public function run(string $id = null): string|Response
    {
        $categoryForm = new $this->controller->formModelClass($this->id);
        $this->ajaxValidator->validate($categoryForm);

        $registerEvent = new CategoryEvent($id);
        $this->trigger(CategoryEvent::BEFORE_REGISTER, $registerEvent);

        $seoForm = new SeoForm();

        if (
            $categoryForm->load($this->request->post()) &&
            $seoForm->load($this->request->post()) &&
            $categoryForm->validate() &&
            $seoForm->validate() &&
            $this->registerService->run($this->category, $categoryForm, $id) &&
            $this->seoService->run($this->seo, $seoForm, Category::class, $categoryForm->id)
        ) {
            $this->trigger(CategoryEvent::AFTER_REGISTER, $registerEvent);

            return $this->controller->redirect(['category/index']);
        }

        return $this->controller->render(
            '_form',
            [
                'blogModule' => $this->blogModule,
                'buttonTitle' => Yii::t('yii.blog', 'Register'),
                'formModel' => $categoryForm,
                'id' => $id,
                'imageFile' => '',
                'nodeTree' => $this->categoryService->buildNodeTree(),
                'seoForm' => $seoForm,
                'title' => Yii::t('yii.blog', 'Register category'),
            ],
        );
    }
}
