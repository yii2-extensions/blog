<?php

declare(strict_types=1);

namespace Yii\Blog\Domain\Post;

use Yii\Blog\Domain\Tag\Tag;
use yii\db\ActiveQuery;
use yii\db\ActiveRecordInterface;

/**
 * Defines the contract for the Post class.
 *
 * @property int $id The ID.
 * @property int $category_id The category ID.
 * @property string $title The title.
 * @property string $content The content.
 * @property string $content_short The short content.
 * @property string $image_file The image file.
 * @property string $slug The slug.
 * @property string $date The date.
 * @property int $views The views.
 * @property string $lang The language.
 * @property int $status The status.
 *
 * Defined relations:
 * @property Tag[] $tags The tags.
 */
interface PostInterface extends ActiveRecordInterface
{
    /**
     * Returns the relational query object for fetching category-related information for this post.
     *
     * @return ActiveQuery The relational query object.
     */
    public function getCategory(): ActiveQuery;

    /**
     * Returns the relational query object for fetching SEO-related information for this post.
     *
     * @return ActiveQuery The relational query object.
     */
    public function getSeo(): ActiveQuery;
}
