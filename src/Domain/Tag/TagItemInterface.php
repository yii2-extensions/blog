<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Tag;

use yii\db\ActiveRecordInterface;

/**
 * Defines the contract for the Tag Item class.
 *
 * @property string $class The class name of the item.
 * @property int $item_id The ID of the item.
 * @property int $tag_id The ID of the tag.
 */
interface TagItemInterface extends ActiveRecordInterface
{
}
