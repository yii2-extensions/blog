<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Category;

use Yii;
use yii\base\Model;
use Yii\Blog\ActiveRecord\Category;
use Yii\Blog\BlogModule;

final class CategoryForm extends Model
{
    public int|null $id = null;
    public string $title = '';
    public string $description = '';
    public string $image_file = '';
    public string $slug = '';
    public int|null $status = null;
    public string $parent = '';

    public function __construct(
        private readonly BlogModule $blogModule,
        private readonly string $action,
        array $config = [],
    ) {
        parent::__construct($config);
    }

    public function attributeLabels(): array
    {
        return [
            'title' => Yii::t('yii.blog', 'Title'),
            'description' => Yii::t('yii.blog', 'Description'),
            'image_file' => Yii::t('yii.blog', 'Image'),
            'slug' => Yii::t('yii.blog', 'Slug'),
            'tagNames' => Yii::t('yii.blog', 'Tags'),
        ];
    }

    public function rules(): array
    {
        return [
            ['title', 'required'],
            ['title', 'trim'],
            ['title', 'string', 'max' => 128],
            [
                'title',
                'unique',
                'targetClass' => Category::class,
                'message' => Yii::t('yii.blog', 'This title has already been taken.'),
                'when' => fn (): bool => $this->action === 'register',
            ],
            ['description', 'string', 'max' => 1024],
            ['image_file', 'image'],
            ['slug', 'string', 'max' => 128],
            ['parent', 'string'],
            ['status', 'integer'],
            [
                'status',
                'default',
                'value' => BlogModule::STATUS_ACTIVE,
                'when' => fn (): bool => $this->action === 'register',
            ],
        ];
    }
}
