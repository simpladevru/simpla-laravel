<?php

namespace App\Entity\Shop\Product;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Variant
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $sku
 * @property int $stock
 * @property float $price
 * @property float $compare_price
 * @property int $sort
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereComparePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Variant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Variant extends Model
{
    protected $guarded = ['id'];
}
