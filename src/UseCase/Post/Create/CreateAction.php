<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post\Create;

use Yii;
use yii\base\Action;
use Yii\Blog\ActiveRecord\Post;
use Yii\Blog\BlogModule;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\Blog\UseCase\Post\PostEvent;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\CoreLibrary\Validator\AjaxValidator;
use yii\db\Connection;
use yii\web\Controller;
use yii\web\CookieCollection;
use yii\web\Request;
use yii\web\Response;

final class CreateAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        private readonly AjaxValidator $ajaxValidator,
        private readonly BlogModule $blogModule,
        private readonly CategoryService $categoryService,
        private readonly CreateService $createService,
        private readonly Connection $db,
        private readonly Request $request,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    public function run(): string|Response
    {
        $postForm = new $this->controller->formModelClass(
            $this->blogModule,
            $this->controller->action->id,
        );

        $this->ajaxValidator->validate($postForm);

        $createEvent = new PostEvent();
        $this->trigger(PostEvent::BEFORE_CREATE, $createEvent);

        $seoForm = new SeoForm();

        if (
            $postForm->load($this->request->post()) &&
            $postForm->validate() &&
            $seoForm->load($this->request->post()) &&
            $seoForm->validate() &&
            $this->createService->run($postForm)
        ) {
            $this->trigger(PostEvent::AFTER_CREATE, $createEvent);

            return $this->controller->redirect('/');
        }

        return $this->controller->render(
            '_form',
            [
                'blogModule' => $this->blogModule,
                'formModel' => $postForm,
                'imageFile' => '',
                'nodeTree' => $this->categoryService->buildNodeTree(),
                'seoForm' => $seoForm,
                'title' => Yii::t('yii.blog', 'Create post'),
            ],
        );
    }
}
