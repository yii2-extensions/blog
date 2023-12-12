<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Seo;

use yii\db\ActiveRecordInterface;

/**
 * Defines the contract for the Seo class.
 *
 * @property int $id The ID.
 * @property string $class The class name of the item.
 * @property int $item_id The ID of the item.
 * @property string $keywords The keywords.
 * @property string $description The description.
 */
interface SeoInterface extends ActiveRecordInterface
{
}
