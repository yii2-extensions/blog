<?php

declare(strict_types=1);

namespace Yii\Blog\UseCase\Post;

use Yii;
use yii\base\Model;
use Yii\Blog\BlogModule;
use Yii\Blog\Domain\Category\Category;

final class PostForm extends Model
{
    public int|null $id = null;
    public int|null $category_id = null;
    public string $title = '';
    public string $content = '';
    public string $content_short = '';
    public array|string|null $image_file = null;
    public string $slug = '';
    public string $date = '';
    public string $lang = '';
    public int|null $status = null;
    public string $tagNames = '';

    public function attributeLabels(): array
    {
        return [
            'category_id' => Yii::t('yii.blog', 'Category'),
            'title' => Yii::t('yii.blog', 'Title'),
            'content' => '',
            'content_short' => Yii::t('yii.blog', 'Content Short'),
            'date' => Yii::t('yii.blog', 'Date'),
            'image_file' => '',
            'slug' => Yii::t('yii.blog', 'Slug'),
            'status' => Yii::t('yii.blog', 'Status'),
            'tagNames' => Yii::t('yii.blog', 'Tags'),
        ];
    }

    public function rules(): array
    {
        return [
            ['category_id', 'integer'],
            ['category_id', 'required'],
            [
                'category_id',
                'exist',
                'targetClass' => Category::class,
                'targetAttribute' => 'id',
                'message' => Yii::t('yii.blog', 'This category does not exist.'),
            ],
            ['title', 'required'],
            ['title', 'trim'],
            ['title', 'string', 'max' => 128],
            ['content_short' , 'required'],
            ['content_short' , 'trim'],
            ['content_short' , 'string', 'max' => 1024],
            ['content', 'required'],
            ['content', 'trim'],
            ['content', 'string'],
            ['slug', 'trim'],
            ['slug', 'string', 'max' => 128],
            ['date', 'default', 'value' => strtotime(date('Y-m-d H:i:s'))],
            [
                'status',
                'default',
                'value' => BlogModule::STATUS_ACTIVE,
            ],
            ['tagNames', 'safe'],
            ['image_file', 'default', 'value' => ''],
            ['lang', 'default', 'value' => 'en'],
        ];
    }
}
