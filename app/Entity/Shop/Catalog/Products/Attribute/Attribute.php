<?php

namespace App\Entity\Shop\Catalog\Products\Attribute;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Shop\Catalog\Products\Attribute\Attribute
 *
 * @property int $id
 * @property int $product_id
 * @property int $feature_id
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Attribute\Attribute whereValue($value)
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    protected $table   = 'product_attributes';

    protected $guarded = ['id'];
}
