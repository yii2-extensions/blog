<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\Behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\db\Query;

final class SortableBehavior extends Behavior
{
    public function events(): array
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'findMaxOrderNum',
        ];
    }

    public function findMaxOrderNum(): void
    {
        if(!$this->owner->order_num) {
            $maxOrderNum = (int) (new Query())->select('MAX(`order_num`)')->from($this->owner->tableName())->scalar();
            $this->owner->order_num = ++$maxOrderNum;
        }
    }
}
