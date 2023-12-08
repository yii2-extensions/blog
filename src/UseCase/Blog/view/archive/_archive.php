<?php

declare(strict_types=1);

use PHPForge\Html\Div;
use PHPForge\Html\H;
use PHPForge\Html\Span;
use PHPForge\Html\Tag;
use Yii\Blog\Framework\Asset\BlogAsset;
use yii\db\ActiveRecord;
use yii\web\View;

/**
 * @var ActiveRecord[] $trendings
 * @var View $this
 */
BlogAsset::register($this);

$items = [];
?>

<?= Div::widget()->class('media mt-5')->begin() ?>
    <?php foreach ($trendings as $trending): ?>
        <?=
            Div::widget()
                ->class('media-body')
                ->content(
                    Span::widget()
                        ->class('text-muted letter-spacing text-uppercase font-sm')
                        ->content(Yii::$app->formatter->asDate($trending->date, 'medium')),
                    H::widget()
                        ->class('text-dark font-weight-bold')
                        ->content($trending->title)
                        ->tagName('h4'),
                    H::widget()
                        ->class('text-muted font-xs')
                        ->content($trending->content_short)
                        ->tagName('h5'),
                    Tag::widget()->class('mb-4')->tagName('hr'),
                )
        ?>
    <?php endforeach; ?>
<?= Div::end();
