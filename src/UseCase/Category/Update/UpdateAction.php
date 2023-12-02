<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category\Update;

use Yii;
use yii\base\Action;
use yii\base\ExitException;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Category\CategoryInterface;
use Yii\Blog\Service\ApiService;
use Yii\Blog\UseCase\Category\CategoryEvent;
use Yii\Blog\UseCase\Category\CategoryService;
use Yii\Blog\UseCase\Seo\SeoForm;
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
        public readonly ApiService $apiService,
        public readonly BlogModule $blogModule,
        public readonly CategoryInterface $category,
        public readonly CategoryService $categoryService,
        public readonly PersistenceRepository $persistenceRepository,
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
        /** @var Category $category */
        $category = $this->apiService->getCategoryBySlug($slug);

        $id = $category->id ?? null;
        $registerEvent = new CategoryEvent($id);

        if ($category === null) {
            $this->trigger(CategoryEvent::NOT_FOUND, $registerEvent);

            return $this->controller->redirect(['category/index']);
        }

        $seo = $category->seo;

        $this->trigger(CategoryEvent::BEFORE_UPDATE, $registerEvent);

        $categoryForm = new $this->controller->formModelClass($this->id);

        $categoryForm->id = $id;

        $categoryForm->setAttributes($category->getAttributes());

        $seoForm = new SeoForm();
        $seoForm->setAttributes($seo->getAttributes());

        $this->ajaxValidator->validate($categoryForm);
        $this->ajaxValidator->validate($seoForm);

        if (
            $categoryForm->load($this->request->post()) &&
            $seoForm->load($this->request->post()) &&
            $categoryForm->validate() &&
            $seoForm->validate()
        ) {
            match ($this->updateService->run($category, $categoryForm, $seoForm)) {
                true => $this->trigger(CategoryEvent::AFTER_UPDATE, $registerEvent),
                default => $this->trigger(CategoryEvent::NOT_UPDATE, $registerEvent),
            };

            return $this->controller->redirect(['category/index']);
        }

        return $this->controller->render(
            '_form',
            [
                'blogModule' => $this->blogModule,
                'buttonTitle' => Yii::t('yii.blog', 'Update'),
                'formModel' => $categoryForm,
                'id' => $category->id === $category->tree ? null : $category->tree,
                'imageFile' => $category->image_file !== ''
                    ? '/uploads' . '/' . $category->image_file
                    : '',
                'nodeTree' => $this->categoryService->buildNodeTree(),
                'seoForm' => $seoForm,
                'title' => Yii::t('yii.blog', 'Update category'),
            ],
        );
    }
}
