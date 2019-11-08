<?php

namespace App\Entity\Shop\Catalog\Products\Variant;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Shop\Catalog\Products\Variant\Variant
 *
 * @property int $id
 * @property int|null $product_id
 * @property string|null $name
 * @property string|null $sku
 * @property int|null $stock
 * @property float|null $price
 * @property float|null $compare_price
 * @property int|null $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Variant\Variant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Variant extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'sku',
        'stock',
        'price',
        'compare_price',
        'product_id',
        'sort',
    ];
}
