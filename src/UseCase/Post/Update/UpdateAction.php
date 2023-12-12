<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post\Update;

use Yii;
use yii\base\Action;
use yii\base\ExitException;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Domain\Post\PostInterface;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\Blog\UseCase\Post\PostEvent;
use Yii\Blog\UseCase\Seo\SeoForm;
use Yii\CoreLibrary\Repository\FinderRepositoryInterface;
use Yii\CoreLibrary\Repository\PersistenceRepository;
use Yii\CoreLibrary\Validator\AjaxValidator;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

final class UpdateAction extends Action
{
    public function __construct(
        string $id,
        Controller $controller,
        public readonly AjaxValidator $ajaxValidator,
        public readonly BlogModule $blogModule,
        public readonly CategoryService $categoryService,
        public readonly FinderRepositoryInterface $finderRepository,
        public readonly PersistenceRepository $persistenceRepository,
        public readonly PostInterface $post,
        private readonly Request $request,
        private readonly UpdateService $updateService,
        array $config = []
    ) {
        parent::__construct($id, $controller, $config);
    }

    /**
     * @throws ExitException
     */
    public function run(string $slug = null): string|Response
    {
        /** @var Post $post */
        $post = $this->finderRepository->findByOneCondition($this->post, ['slug' => $slug]);
        $id = $post->id ?? null;

        $registerEvent = new PostEvent();

        if ($post === null) {
            $this->trigger(PostEvent::NOT_FOUND, $registerEvent);

            return $this->controller->redirect(['post/index']);
        }

        $seo = $post->seo;

        $this->trigger(PostEvent::BEFORE_UPDATE, $registerEvent);

        $postForm = new $this->controller->formModelClass();
        $postForm->id = $id;

        $postForm->setAttributes($post->getAttributes());
        $postForm->date = date('Y-m-d H:i:s', (int) $post->date);
        $postForm->tagNames = $post->getTagNames();

        $seoForm = new SeoForm();
        $seoForm->setAttributes($seo->getAttributes());

        $this->ajaxValidator->validate($postForm);
        $this->ajaxValidator->validate($seoForm);

        if ($postForm->load($this->request->post()) && $seoForm->load($this->request->post()) && $postForm->validate()) {
            match ($this->updateService->run($post, $postForm, $seoForm)) {
                true => $this->trigger(PostEvent::AFTER_UPDATE, $registerEvent),
                default => $this->trigger(PostEvent::NOT_UPDATE, $registerEvent),
            };

            return $this->controller->redirect(['post/index']);
        }

        return $this->controller->render(
            '_form',
            [
                'blogModule' => $this->blogModule,
                'buttonTitle' => Yii::t('yii.blog', 'Update'),
                'formModel' => $postForm,
                'imageFile' => $post->image_file !== ''
                    ? '/uploads' . '/' . $post->image_file
                    : '',
                'nodeTree' => $this->categoryService->buildNodeTreeWithDepth(),
                'seoForm' => $seoForm,
                'title' => Yii::t('yii.blog', 'Update posts'),
            ],
        );
    }
}
