<?php

namespace App\Entity\Shop\Catalog\Brand;

use App\Helpers\Tables;
use App\Helpers\ImageHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Entity\Shop\Catalog\Products\Product\Product;

/**
 * Class Brand
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $image
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Shop\Catalog\Products\Product\Product[] $products
 * @property-read int|null $products_count
 */
class Brand extends Model
{
    protected $table = Tables::SHOP_BRANDS;

    protected $guarded = ['id'];

    protected $fillable = [
        'id',
        'name',
        'image',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Получить отношение к товарам.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }

    /**
     * @param int $width
     * @param int $height
     * @param bool $set_watermark
     * @return string
     */
    public function getResizedUrl(int $width = 0, int $height = 0, bool $set_watermark = false)
    {
        if (!$this->image) {
            return '';
        }

        return app(ImageHelper::class)->getResizedUrl(
            'public',
            'brands',
            $this->image,
            $width,
            $height,
            $set_watermark
        );
    }
}
