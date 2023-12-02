<?php

declare(strict_types=1);

namespace Yii\Blog\Framework\Behavior;

use Yii;
use yii\base\Behavior;
use Yii\Blog\Domain\Tag\Tag;
use Yii\Blog\Domain\Tag\TagItem;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

use function array_unique;
use function count;
use function get_class;
use function implode;
use function preg_replace;
use function preg_split;

final class Taggable extends Behavior
{
    private array $tags = [];

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function getTagItem(): ActiveQuery
    {
        return $this->owner->hasMany(
            TagItem::class,
            ['item_id' => $this->owner->primaryKey()[0]])->where(['class' => $this->getClass()],
        );
    }

    public function getTags(): ActiveQuery
    {
        return $this->owner->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagItem');
    }

    public function getTagNames(): string
    {
        $tags = [];

        foreach ($this->owner->tags as $tag) {
            $tags[] = $tag->name;
        }

        return implode(', ', $tags);
    }

    public function setTagNames(string $values): void
    {
        $this->tags = $this->filterTagValues($values);
    }

    public function getTagArray(): array
    {
        if ($this->tags === []){

            foreach($this->owner->tags as $tag) {
                $this->tags[] = $tag->name;
            }
        }

        return $this->tags;
    }

    /**
     * @throws Exception
     */
    public function afterSave(): void
    {
        $updatedTags = [];

        if($this->owner->isNewRecord === false) {
            $this->beforeDelete();
        }

        if (count($this->tags)) {
            $tagItem = [];
            $modelClass = $this->getClass();

            foreach ($this->tags as $name) {
                if (($tag = Tag::findOne(['name' => $name])) === null) {
                    $tag = new Tag(['name' => $name]);
                }

                $tag->frequency++;

                if ($tag->save()) {
                    $updatedTags[] = $tag;
                    $tagItem[] = [$modelClass, $this->owner->primaryKey, $tag->id];
                }
            }

            if (count($tagItem)) {
                Yii::$app->db->createCommand()->batchInsert(
                    TagItem::tableName(),
                    ['class', 'item_id', 'tag_id'],
                    $tagItem,
                )->execute();

                $this->owner->populateRelation(Tag::class, $updatedTags);
            }
        }
    }

    public function beforeDelete(): void
    {
        $pks = [];

        foreach($this->owner->tags as $tag){
            $pks[] = $tag->primaryKey;
        }

        if (count($pks)) {
            Tag::updateAllCounters(['frequency' => -1], ['in', 'id', $pks]);
        }

        Tag::deleteAll(['frequency' => 0]);
        TagItem::deleteAll(['class' => $this->getClass(), 'item_id' => $this->owner->primaryKey]);
    }

    public function filterTagValues(string $values): array
    {
        return array_unique(
            preg_split(
                '/\s*,\s*/u',
                preg_replace('/\s+/u', ' ', $values),
                -1,
                PREG_SPLIT_NO_EMPTY
            ),
        );
    }

    private function getClass(): string
    {
        if ($this->owner !== null) {
            return get_class($this->owner);
        }

        return '';
    }
}
