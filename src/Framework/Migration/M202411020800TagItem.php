<?php

declare(strict_types=1);

use Yii\Blog\ActiveRecord\TagItem;
use Yii\Blog\Framework\Migration\Migration;

final class M202411020800TagItem extends Migration
{
    public function up(): void
    {
        $this->createTable(
            TagItem::tableName(),
            [
                'class' => $this->string(128)->notNull(),
                'item_id' => $this->integer()->notNull(),
                'tag_id' => $this->integer()->notNull(),
            ],
            $this->tableOptions,
        );

        $this->createIndex('class', TagItem::tableName(), 'class');
        $this->createIndex('item_tag', TagItem::tableName(), ['item_id', 'tag_id']);
    }

    public function down(): void
    {
        $this->dropTable(TagItem::tableName());
    }
}
