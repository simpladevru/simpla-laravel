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
 */
class Attribute extends Model
{
    protected $table   = 'product_attributes';

    protected $guarded = ['id'];
}
