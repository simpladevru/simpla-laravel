<?php

namespace App\Entity\Shop\Catalog\Product\Product\Pivot;

use App\Helpers\Tables;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot
 *
 * @property int $product_id
 * @property int $category_id
 * @property int $sort
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Shop\Catalog\Product\Product\Pivot\CategoryPivot whereSort($value)
 * @mixin \Eloquent
 */
class CategoryPivot extends Pivot
{
    protected $table = Tables::PRODUCT_CATEGORIES;
}
