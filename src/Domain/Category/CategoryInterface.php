<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Category;

use yii\db\ActiveQuery;
use yii\db\ActiveRecordInterface;

/**
 * Defines the contract for the Category class.
 *
 * @property int $id The ID.
 * @property string $title The title.
 * @property string $description The description.
 * @property string $image_file The image file.
 * @property int $order_num The order number.
 * @property string $slug The slug.
 * @property int $tree The tree.
 * @property int $lft The left.
 * @property int $rgt The right.
 * @property int $depth The depth.
 * @property int $status The status.
 */
interface CategoryInterface extends ActiveRecordInterface
{
    /**
     * Returns the relational query object for fetching posts related to this category.
     *
     * @return ActiveQuery The relational query object.
     */
    public function getPost(): ActiveQuery;

    /**
     * Returns the relational query object for fetching SEO-related information for this category.
     *
     * @return ActiveQuery The relational query object.
     */
    public function getSeo(): ActiveQuery;
}
