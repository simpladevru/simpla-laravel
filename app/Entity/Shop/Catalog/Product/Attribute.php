<?php

namespace App\Entity\Shop\Product;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Shop\Product\Attribute
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $feature_id
 * @property int $product_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Product\Attribute whereValue($value)
 */
class Attribute extends Model
{
    protected $table   = 'product_attributes';

    protected $guarded = ['id'];
}
