<?php

declare(strict_types=1);

use Yii\Blog\ActiveRecord\Photos;
use Yii\Blog\Framework\Migration\Migration;

final class M202411020800Photos extends Migration
{
    public function up(): void
    {
        $this->createTable(
            Photos::tableName(),
            [
                'id' => $this->primaryKey(),
                'class' => $this->string(128)->notNull(),
                'item_id' => $this->integer()->notNull(),
                'image_file' => $this->string(128)->notNull(),
                'description' => $this->string(1024),
                'order_num' => $this->integer()->defaultValue(0),
            ],
            $this->tableOptions,
        );

        $this->createIndex('photos_index_item', Photos::tableName(), ['class', 'item_id']);
    }

    public function down(): void
    {
        $this->dropTable(Photos::tableName());
    }
}
