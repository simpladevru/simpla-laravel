<?php

namespace App\Entity\Shop\Catalog\Products\Image;

use App\Helpers\Tables;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    const FILE_PATH = 'products';

    protected $table = Tables::SHOP_PRODUCT_IMAGES;

    protected $fillable = ['file', 'sort'];

    /**
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedUrl(int $width = 0, int $height = 0, bool $set_watermark = false)
    {
        if (!$this->file) {
            return '';
        }

        return app(ImageHelper::class)->getResizedUrl(
            env('PRODUCT_IMAGE_STORAGE_DISK'),
            env('PRODUCT_IMAGE_STORAGE_PUBLIC'),
            $this->file,
            $width,
            $height,
            $set_watermark
        );
    }
}
