<?php

declare(strict_types=1);

use Yii\Blog\Domain\Seo\Seo;
use Yii\Blog\Framework\Migration\Migration;

final class M202411020800Seo extends Migration
{
    public function up(): void
    {
        $this->createTable(
            Seo::tableName(),
            [
                'id' => $this->primaryKey(),
                'class' => $this->string(128)->notNull(),
                'item_id' => $this->integer()->notNull(),
                'h1' => $this->string(255),
                'title' => $this->string(255),
                'keywords' => $this->string(255),
                'description' => $this->string(255),
            ],
            $this->tableOptions,
        );

        $this->createIndex('seo_item', Seo::tableName(), ['class', 'item_id'], true);
    }

    public function down(): void
    {
        $this->dropTable(Seo::tableName());
    }
}
