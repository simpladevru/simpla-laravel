<?php

namespace App\Entity\Shop\Product\Image;

use App\Helpers\ImageHelper;
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
        return app(ImageHelper::class)->getResizedFilename($this->file, $width, $height, $set_watermark);
    }
}
