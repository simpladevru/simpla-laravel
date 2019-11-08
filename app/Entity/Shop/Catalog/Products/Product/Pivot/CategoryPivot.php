<?php

namespace App\Entity\Shop\Catalog\Products\Product\Pivot;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot
 *
 * @property int $product_id
 * @property int $category_id
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Products\Product\Pivot\CategoryPivot whereSort($value)
 * @mixin \Eloquent
 */
class CategoryPivot extends Pivot
{
    protected $table = Tables::PRODUCT_CATEGORIES;
}
