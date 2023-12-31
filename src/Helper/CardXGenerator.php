<?php

declare(strict_types=1);

namespace Yii\Blog\Helper;

use Yii;

use function copy;
use function file_exists;
use function imagecolorallocate;
use function imagecreatefrompng;
use function imagedestroy;
use function imagepng;
use function imagesx;
use function imagesy;
use function imagettfbbox;
use function imagettftext;

final class CardXGenerator
{
    public static function generate(string $id, string $title): void
    {
        $dirImage = Yii::getAlias('@image');
        $dirResource = dirname(__DIR__) . '/Framework/resource/';
        $dirUploads = Yii::getAlias('@uploads');

        if (file_exists("$dirUploads/cardx-$id.png")) {
            copy("$dirUploads/cardx-$id.png", "$dirImage/cardx-$id.png");
            return;
        }

        $text = $title;
        $font = "$dirResource/font/ArialBlack.ttf";
        $size = 40;

        $im = imagecreatefrompng("$dirResource/image/cardx.png");
        $black = imagecolorallocate($im, 0, 0, 0);
        $image_width = imagesx($im);
        $image_height = imagesy($im);
        $lines = explode("\n", wordwrap($text, (int) ($image_width / ($size * 0.75)), "\n"));
        $total_height = count($lines) * $size * 1.5;

        $y_start = (int) (($image_height - $total_height) / 2);

        foreach ($lines as $i => $line) {
            $line_bbox = imagettfbbox($size, 0, $font, $line);

            $line_width = $line_bbox[2] - $line_bbox[0];
            $x = (int) (($image_width - $line_width) / 2);
            $y = $y_start + (int) ($i * $size * 1.5);

            imagettftext($im, $size, 0, $x, $y, $black, $font, $line);
        }

        imagepng($im, "$dirUploads/cardx-$id.png");
        copy("$dirUploads/cardx-$id.png", "$dirImage/cardx-$id.png");
        imagedestroy($im);
    }
}
