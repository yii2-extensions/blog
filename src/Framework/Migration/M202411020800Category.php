<?php

declare(strict_types=1);

use Yii\Blog\ActiveRecord\Category;
use Yii\Blog\Framework\Migration\Migration;

final class M202411020800Category extends Migration
{
    public function up(): void
    {
        $this->createTable(
            Category::tableName(),
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(128)->notNull(),
                'description' => $this->string(1024),
                'image_file' => $this->string(128),
                'order_num' => $this->integer(),
                'slug' => $this->string(128),
                'tree' => $this->integer(),
                'lft' => $this->integer(),
                'rgt' => $this->integer(),
                'depth' => $this->integer(),
                'status' => $this->boolean()->defaultValue(1)
            ],
            $this->tableOptions,
        );

        $this->createIndex('category_index_title', Category::tableName(), 'title', true);
        $this->createIndex('category_index_slug', Category::tableName(), 'slug', true);
    }

    public function down(): void
    {
        $this->dropTable(Category::tableName());
    }
}
