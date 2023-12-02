<?php

declare(strict_types=1);

use Yii\Blog\Domain\Category\Category;
use Yii\Blog\Domain\Post\Post;
use Yii\Blog\Framework\Migration\Migration;

final class M202411020800Post extends Migration
{
    public function up(): void
    {
        $this->createTable(
            Post::tableName(),
            [
                'id' => $this->primaryKey(),
                'category_id' => $this->integer()->notNull(),
                'title' => $this->string(128)->notNull(),
                'content' => $this->text(),
                'content_short' => $this->string(1024),
                'image_file' => $this->string(128),
                'slug' => $this->string(128),
                'date' => $this->integer(),
                'views' => $this->integer()->defaultValue(0),
                'lang' => $this->string(2)->notNull()->defaultValue('en'),
                'status' => $this->integer()->defaultValue(0),
            ],
            $this->tableOptions,
        );

        $this->createIndex('post_slug', Category::tableName(), 'slug', true);
    }

    public function down(): void
    {
        $this->dropTable(Post::tableName());
    }
}
