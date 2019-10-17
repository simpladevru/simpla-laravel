<?php

namespace App\Entity\Shop\Product;

use App\Entity\Shop\Product\Image\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Entity\Shop\Product\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int|null $brand_id
 * @property int|null $featured
 * @property string|null $annotation
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereAnnotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property Collection $variants
 * @property Collection|Image[] images
 */
class Product extends Model
{
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class, 'product_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }
}
