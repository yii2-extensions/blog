<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Tag;

use yii\db\ActiveRecordInterface;

/**
 * Defines the contract for the Tag class.
 *
 * @property string $id The ID.
 * @property string $name The name.
 * @property int $frequency The frequency.
 */
interface TagInterface extends ActiveRecordInterface
{
}
