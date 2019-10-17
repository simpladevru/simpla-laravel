<?php

namespace App\Entity\Shop\Product\Image;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * App\Entity\Shop\Product\Image
 * @property UploadedFile|string $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image query()
 * @mixin Eloquent
 */
class Image extends Model
{
    const FILE_PATH = 'products';

    protected $table = 'product_images';

    protected $fillable = ['file', 'sort'];

    /**
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedFilename($width = 0, $height = 0, $set_watermark = false)
    {
        $file = $this->getFilename();
        $ext  = $this->getExtension();

        if ($width > 0 || $height > 0) {
            $resizedFilename = $file . '.' . ($width > 0 ? $width : '') . 'x' . ($height > 0 ? $height : '') . ($set_watermark ? 'w' : '') . '.' . $ext;
        } else {
            $resizedFilename = $file . '.' . ($set_watermark ? 'w.' : '') . $ext;
        }

        return $resizedFilename;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return pathinfo($this->file, PATHINFO_FILENAME);
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }
}
