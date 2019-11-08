<?php

namespace App\Entity\Shop\Catalog\Product\Image;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Shop\Catalog\Product\Image\Image
 *
 * @property int $id
 * @property int $product_id
 * @property string $file
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Image\Image whereUpdatedAt($value)
 * @mixin \Eloquent
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
    public function getResizedUrl(int $width = 0, int $height = 0, bool $set_watermark = false)
    {
        if (!$this->file) {
            return '';
        }

        return app(ImageHelper::class)->getResizedUrl(
            'public',
            'products',
            $this->file,
            $width,
            $height,
            $set_watermark
        );
    }
}
