<?php

declare(strict_types=1);

use Yii\Blog\Domain\Tag\Tag;
use Yii\Blog\Framework\Migration\Migration;

final class M202411020800Tag extends Migration
{
    public function up(): void
    {
        $this->createTable(
            Tag::tableName(),
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(128)->notNull(),
                'frequency' => $this->integer()->defaultValue(0)
            ],
            $this->tableOptions,
        );

        $this->createIndex('name', Tag::tableName(), 'name', true);
    }

    public function down(): void
    {
        $this->dropTable(Tag::tableName());
    }
}
