<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post\Create;

use Yii;
use yii\base\Action;
use yii\base\ExitException;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Post\PostInterface;
use Yii\Blog\Domain\Seo\SeoInterface;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\Blog\UseCase\Post\PostEvent;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\Blog\UseCase\Seo\SeoService;
use Yii\CoreLibrary\Validator\AjaxValidator;
use yii\web\Controller;
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
        private readonly PostInterface $post,
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
    public function run(): string|Response
    {
        $postForm = new $this->controller->formModelClass();

        $this->ajaxValidator->validate($postForm);

        $createEvent = new PostEvent();
        $this->trigger(PostEvent::BEFORE_CREATE, $createEvent);

        $seoForm = new SeoForm();

        if (
            $postForm->load($this->request->post()) &&
            $postForm->validate() &&
            $seoForm->load($this->request->post()) &&
            $seoForm->validate() &&
            $this->createService->run($this->post, $postForm) &&
            $this->seoService->run($this->seo, $seoForm, PostInterface::class, $postForm->id)
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
                'nodeTree' => $this->categoryService->buildNodeTreeWithDepth(),
                'seoForm' => $seoForm,
                'title' => Yii::t('yii.blog', 'Create post'),
            ],
        );
    }
}
