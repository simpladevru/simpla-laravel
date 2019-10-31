<?php

namespace App\Entity\Shop\Product\Image;

use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * App\Entity\Shop\Product\Image
 *
 * @property UploadedFile|string $file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image query()
 * @mixin Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image\Image whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image\Image whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image\Image whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Image\Image whereUpdatedAt($value)
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
